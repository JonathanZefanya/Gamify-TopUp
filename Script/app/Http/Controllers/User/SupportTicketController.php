<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\UserTrackingJob;
use App\Models\Admin;
use App\Models\SupportTicket;
use App\Models\SupportTicketAttachment;
use App\Models\SupportTicketMessage;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SupportTicketController extends Controller
{
    use Upload, Notify;


    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->paginate(basicControl()->paginate);

        return view(template() . "user.".getDash().".support_ticket.index", compact('tickets'));
    }

    public function create()
    {
        return view(template() . "user.".getDash().".support_ticket.create");
    }

    public function store(Request $request)
    {
        $random = rand(100000, 999999);
        $this->newTicketValidation($request);
        $ticket = $this->saveTicket($request, $random);
        $message = $this->saveMsgTicket($request, $ticket);

        if (!empty($request->attachments)) {
            $numberOfAttachments = count($request->attachments);
            for ($i = 0; $i < $numberOfAttachments; $i++) {
                if ($request->hasFile('attachments.' . $i)) {
                    $file = $request->file('attachments.' . $i);
                    $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'), null, null, 'webp');
                    if (empty($supportFile['path'])) {
                        throw new \Exception('File could not be uploaded.');
                    }
                    $this->saveAttachment($message, $supportFile['path'], $supportFile['driver']);
                }
            }
        }

        $remark = 'Create new support ticket <a href="' . route('admin.ticket.view', $ticket->id) . '">Click here</a> to see details';
        UserTrackingJob::dispatch($ticket->user_id, request()->ip(), $remark);

        $msg = [
            'username' => optional($ticket->user)->fullname,
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
        return redirect()->route('user.ticket.list')->with('success', 'Your ticket has been pending.');
    }

    public function ticketView($ticketId)
    {
        $ticket = SupportTicket::where('ticket', $ticketId)->latest()->with('messages')->firstOrFail();
        $user = Auth::user();
        $admin = Admin::firstOrNew();
        return view(template() . 'user.'.getDash().'.support_ticket.view', compact('ticket', 'user', 'admin'));
    }

    public function reply(Request $request, $id)
    {
        if ($request->reply_ticket == 1) {
            $images = $request->file('attachments');
            $allowedExtensions = array('jpg', 'png', 'jpeg', 'pdf');
            $this->validate($request, [
                'attachments' => [
                    'max:10240',
                    function ($fail) use ($images, $allowedExtensions) {
                        foreach ($images as $img) {
                            $ext = strtolower($img->getClientOriginalExtension());
                            if (($img->getSize() / 1000000) > 2) {
                                throw ValidationException::withMessages(['attachments' => "Images MAX  10MB ALLOW!"]);
                            }
                            if (!in_array($ext, $allowedExtensions)) {
                                throw ValidationException::withMessages(['attachments' => "Only png, jpg, jpeg, pdf images are allowed"]);
                            }
                        }
                        if (count($images) > 5) {
                            throw ValidationException::withMessages(['attachments' => "Maximum 5 images can be uploaded"]);
                        }
                    },
                ],
                'message' => 'required',
            ]);

            try {
                $ticket = SupportTicket::findOrFail($id);
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
                            $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'), null, null, 'webp');
                            if (empty($supportFile['path'])) {
                                throw new \Exception('File could not be uploaded.');
                            }
                            $this->saveAttachment($message, $supportFile['path'], $supportFile['driver']);
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
                return back()->with('success', 'Ticket has been replied');
            } catch (\Exception $exception) {
                return back()->with('error', $exception->getMessage());
            }

        } elseif ($request->reply_ticket == 2) {
            $ticket = SupportTicket::findOrFail($id);
            $ticket->update([
                'status' => 3,
                'last_reply' => Carbon::now()
            ]);

            $remark = 'Support ticket closed <a href="' . route('admin.ticket.view', $ticket->id) . '">Click here</a> to see details';
            UserTrackingJob::dispatch($ticket->id, request()->ip(), $remark);

            return back()->with('success', 'Ticket has been closed');
        }
        return back();
    }


    public function newTicketValidation(Request $request): void
    {
        $images = $request->file('attachments');
        $allowedExtension = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'max:10240',
                function ($attribute, $value, $fail) use ($images, $allowedExtension) {
                    foreach ($images as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            throw ValidationException::withMessages(['attachments' => "Images MAX  10MB ALLOW!"]);
                        }
                        if (!in_array($ext, $allowedExtension)) {
                            throw ValidationException::withMessages(['attachments' => "Only png, jpg, jpeg, pdf images are allowed"]);
                        }
                    }
                    if (count($images) > 5) {
                        throw ValidationException::withMessages(['attachments' => "Maximum 5 images can be uploaded"]);
                    }
                },
            ],
            'subject' => 'required|max:100',
            'message' => 'required'
        ]);
    }


    public function saveTicket(Request $request, $random)
    {
        try {
            $ticket = SupportTicket::create([
                'user_id' => auth()->id(),
                'ticket' => $random,
                'subject' => $request->subject,
                'status' => 0,
                'last_reply' => Carbon::now(),
            ]);

            if (!$ticket) {
                throw new \Exception('Something went wrong when creating the ticket.');
            }
            return $ticket;
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function saveMsgTicket(Request $request, $ticket)
    {
        try {
            $message = SupportTicketMessage::create([
                'support_ticket_id' => $ticket->id,
                'message' => $request->message
            ]);

            if (!$message) {
                throw new \Exception('Something went wrong when creating the ticket.');
            }
            return $message;
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function saveAttachment($message, $path, $driver)
    {
        try {
            $attachment = SupportTicketAttachment::create([
                'support_ticket_message_id' => $message->id,
                'file' => $path ?? null,
                'driver' => $driver ?? 'local',
            ]);

            if (!$attachment) {
                throw new \Exception('Something went wrong when creating the ticket.');
            }
            return true;
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

}
