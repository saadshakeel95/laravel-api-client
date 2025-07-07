<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Services\Subscriber;

class SubscriberController extends Controller
{

    protected $subscriber;
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscriber(SubscriberRequest $request)
    {

        //Check Subscriber must be at least 18   
        $date = Carbon::parse($request->dateOfBirth);
        if ($date->isPast() && $date->diffInYears(now()) < 18) {
            throw ValidationException::withMessages([
                'date_of_birth' => 'You are minor! Subscriber must be at least 18 years old.',
            ]);
        }
        $subscriberRequest = [
            'emailAddress' => $request->emailAddress ?? null,
            'firstName' =>  $request->firstName ?? null,
            'lastName' => $request->lastName ?? null,
            'dateOfBirth' => $request->dateOfBirth ?? null,
            'marketingConsent' => $request->marketingConsent ?? false,
            'lists' => $request->marketingConsent ? $request->lists : null
        ];

        $subscriberResponse = $this->subscriber->createSubscriber($subscriberRequest);
        $subscriberId = $subscriberResponse['subscriber']['id'] ?? null;

        // Submit Enquiry for this subscriber
        if (!empty($request->message)) {
            $enquiryResponse = $this->subscriber->submitEnquiry($subscriberId, $request->message);
        }

        return response()->json([
            'subscriber' => $subscriberResponse,
            'enquiry' => $enquiryResponse ?? null,
        ]);
    }
}
