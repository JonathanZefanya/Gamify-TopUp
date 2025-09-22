<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Http\Controllers\User\SupportTicketController as webTicketController;

class SupportTicketController extends Controller
{
    use ApiValidation, Notify, Upload;

    public function ticketList()
    {
        if (auth()->id() == null) {
            return response()->json($this->withErrors('Something went wrong'));
        }
        try {
            $array = [];
            $tickets = tap(SupportTicket::where('user_id', auth()->id())->latest()
                ->paginate(basicControl()->paginate), function ($paginatedInstance) use ($array) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array) {
                    $array['ticket'] = $query->ticket;
                    $array['subject'] = '[Ticket#' . $query->ticket . ']' . ucfirst($query->subject);
                    if ($query->status == 0) {
                        $array['status'] = trans('Open');
                    } elseif ($query->status == 1) {
                        $array['status'] = trans('Answered');
                    } elseif ($query->status == 2) {
                        $array['status'] = trans('Replied');
                    } elseif ($query->status == 3) {
                        $array['status'] = trans('Closed');
                    }
                    $array['lastReply'] = Carbon::parse($query->last_reply)->diffForHumans();
                    return $array;
                });
            });

            if ($tickets) {
                return response()->json($this->withSuccess($tickets));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function ticketCreate(Request $request)
    {
        try {

            $random = rand(100000, 999999);
            $this->newTicketValidation($request);
            $ticket = webTicketController::saveTicket($request, $random);
            $message = webTicketController::saveMsgTicket($request, $ticket);

            if (!empty($request->attachments)) {
                $numberOfAttachments = count($request->attachments);
                for ($i = 0; $i < $numberOfAttachments; $i++) {
                    if ($request->hasFile('attachments.' . $i)) {
                        $file = $request->file('attachments.' . $i);
                        $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'), config('filesystems.default'));
                        if (empty($supportFile['path'])) {
                            throw new \Exception('File could not be uploaded.');
                        }
                        webTicketController::saveAttachment($message, $supportFile['path'], $supportFile['driver']);
                    }
                }
            }

            $msg = [
                'user' => optional($ticket->user)->username,
                'ticket_id' => $ticket->ticket
            ];
            $action = [
                "name" => optional($ticket->user)->firstname . ' ' . optional($ticket->user)->lastname,
                "image" => getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image),
                "link" => route('admin.ticket.view', $ticket->id),
                "icon" => "fas fa-ticket-alt text-white"
            ];
            $this->adminPushNotification('SUPPORT_TICKET_CREATE', $msg, $action);
            $this->adminMail('SUPPORT_TICKET_CREATE', $msg);

            return response()->json($this->withSuccess('Your ticket has been pending.'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function newTicketValidation(Request $request)
    {
        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');


        $this->validate($request, [
            'attachments' => [
                'max:10240',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return response()->json($this->withErrors('Images MAX  10MB ALLOW!'));
                        }

                        if (!in_array($ext, $allowedExts)) {
                            return response()->json($this->withErrors('Only png, jpg, jpeg, pdf images are allowed'));
                        }
                    }
                    if (count($imgs) > 5) {
                        return response()->json($this->withErrors('Maximum 5 images can be uploaded'));
                    }
                }
            ],
            'subject' => 'required|max:100',
            'message' => 'required'
        ]);
    }


    public function ticketView($ticketId)
    {
        try {
            $ticket = SupportTicket::with('messages')->where('ticket', $ticketId)
                ->latest()->with('messages')->first();

            if (!$ticket) {
                return response()->json($this->withErrors('Ticket not found'));
            }
            $user = auth()->user();
            if (!$user) {
                return response()->json($this->withErrors('User Not Found'));
            }

            $data['id'] = $ticket->id;
            $data['page_title'] = "Ticket: #" . $ticketId . ' ' . $ticket->subject;
            $data['userImage'] = getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image);
            $data['userUsername'] = optional($ticket->user)->username;
            if ($ticket->status == 0) {
                $data['status'] = trans('Open');
            } elseif ($ticket->status == 1) {
                $data['status'] = trans('Answered');
            } elseif ($ticket->status == 2) {
                $data['status'] = trans('Replied');
            } elseif ($ticket->status == 3) {
                $data['status'] = trans('Closed');
            }


            if ($ticket->messages) {
                foreach ($ticket->messages as $key => $message) {
                    $data['messages'][$key] = $message;
                    $data['messages'][$key]['adminImage'] = ($message->admin_id != null ? getFile(optional($message->admin)->image_driver, optional($message->admin)->image) : null);

                    $data['messages'][$key]['attachments'] = collect($message->attachments)->map(function ($attach, $key) {
                        $attach->attachment_path = getFile($attach->driver, $attach->file);
                        $attach->attachment_name = trans('File') . ' ' . ($key + 1);
                    });
                }
            }

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function ticketReply(Request $request)
    {
        if ($request->replayTicket == 1) {
            $images = $request->file('attachments');
            if($images){
                $allowedExtensions = array('jpg', 'png', 'jpeg', 'pdf');
                $this->validate($request, [
                    'attachments' => [
                        'max:10240',
                        function ($fail) use ($images, $allowedExtensions) {
                            foreach ($images as $img) {
                                $ext = strtolower($img->getClientOriginalExtension());
                                if (($img->getSize() / 1000000) > 2) {
                                    return response()->json($this->withErrors('Images MAX  10MB ALLOW!'));
                                }
                                if (!in_array($ext, $allowedExtensions)) {
                                    return response()->json($this->withErrors('Only png, jpg, jpeg, pdf images are allowed'));
                                }
                            }
                            if (count($images) > 5) {
                                return response()->json($this->withErrors('Maximum 5 images can be uploaded'));
                            }
                        },
                    ],
                    'message' => 'required',
                ]);
            }

            try {
                $ticket = SupportTicket::findOrFail($request->id);
                $ticket->update([
                    'status' => 2,
                    'last_reply' => Carbon::now()
                ]);

                $message = SupportTicketMessage::create([
                    'support_ticket_id' => $ticket->id,
                    'message' => $request->message
                ]);

                if (!empty($request->attachments)) {
                    $numberOfAttachments = count($request->attachments);
                    for ($i = 0; $i < $numberOfAttachments; $i++) {
                        if ($request->hasFile('attachments.' . $i)) {
                            $file = $request->file('attachments.' . $i);
                            $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'), config('filesystems.default'));
                            if (empty($supportFile['path'])) {
                                return response()->json($this->withErrors('File could not be uploaded.'));
                            }
                            webTicketController::saveAttachment($message, $supportFile['path'], $supportFile['driver']);
                        }
                    }
                }

                $msg = [
                    'username' => optional($ticket->user)->username,
                    'ticket_id' => $ticket->ticket
                ];
                $action = [
                    "name" => optional($ticket->user)->firstname . ' ' . optional($ticket->user)->lastname,
                    "image" => getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image),
                    "link" => route('admin.ticket.view', $ticket->id),
                    "icon" => "fas fa-ticket-alt text-white"
                ];

                $this->adminPushNotification('SUPPORT_TICKET_CREATE', $msg, $action);
                return response()->json($this->withSuccess('Ticket has been replied'));
            } catch (\Exception $exception) {
                return response()->json($this->withErrors($exception->getMessage()));
            }

        } elseif ($request->replayTicket == 2) {
            $ticket = SupportTicket::findOrFail($request->id);
            $ticket->update([
                'status' => 3,
                'last_reply' => Carbon::now()
            ]);

            return response()->json($this->withSuccess('Ticket has been closed'));
        }
        return response()->json($this->withErrors('something unexpected'));
    }
}
