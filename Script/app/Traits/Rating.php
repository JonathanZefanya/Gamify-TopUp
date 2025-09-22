<?php


namespace App\Traits;


use App\Models\CardService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TopUp;
use App\Models\Review;
use App\Models\TopUpService;

trait Rating
{

    public function getTopReview($reviewable_type, $reviewable_id)
    {
        $data['reviews'] = Review::with(['user:id,firstname,lastname,email,image_driver,image'])
            ->where('status', 1)
            ->where('reviewable_type', $reviewable_type)
            ->where('reviewable_id', $reviewable_id)
            ->latest()
            ->take(3)
            ->get();

        $orderType = ($reviewable_type == TopUp::class) ? TopUpService::class : CardService::class;
        $parentModel = ($reviewable_type == TopUp::class) ? 'topUp' : 'card';

        $hasAlreadyOrdered = OrderDetail::with(["detailable" => function ($query) use ($parentModel, $reviewable_id) {
            $query->whereHas($parentModel, function ($q) use ($reviewable_id) {
                $q->where('id', $reviewable_id);
            });
        }])
            ->whereHas('order', function ($qq) {
                $qq->where('payment_status', 1);
            })
            ->where('user_id', auth()->id())
            ->where('detailable_type', $orderType)
            ->exists();

        $data['hasAlreadyOrdered'] = $hasAlreadyOrdered;

        return $data;
    }

    public function getAllReviews($reviewable_type, $reviewable_id)
    {
        $reviews = Review::with(['user:id,firstname,lastname,email,image_driver,image'])
            ->where('status', 1)
            ->where('reviewable_type', $reviewable_type)
            ->where('reviewable_id', $reviewable_id)
            ->latest()
            ->get();


        $data['excellentReview'] = $reviews->where('rating', 5);
        $data['excellentCount'] = count($data['excellentReview']);

        $data['greatReview'] = $reviews->where('rating', 4);
        $data['greatCount'] = count($data['greatReview']);

        $data['averageReview'] = $reviews->where('rating', 3);
        $data['averageCount'] = count($data['averageReview']);

        $data['poorReview'] = $reviews->where('rating', 2);
        $data['poorCount'] = count($data['poorReview']);

        $data['badReview'] = $reviews->where('rating', 1);
        $data['badCount'] = count($data['badReview']);

        return $data;
    }

    public function reviewNotifyToAdmin($reviewer, $name, $rating): void
    {
        try {

            $adminParams = [
                'name' => $name ?? null,
                'rating' => $rating ?? 1,
            ];

            $adminAction = [
                "name" => $reviewer->firstname . ' ' . $reviewer->lastname,
                "image" => getFile($reviewer->image_driver, $reviewer->image),
                "link" => route('admin.review.list'),
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $this->adminMail('BUYER_REVIEW_TO_ADMIN', $adminParams);
            $this->adminPushNotification('BUYER_REVIEW_TO_ADMIN', $adminParams, $adminAction);
            $this->adminFirebasePushNotification('BUYER_REVIEW_TO_ADMIN', $adminAction);
        } catch (\Exception $e) {

        }
    }
}
