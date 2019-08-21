<?php

function randomBool(){
    return rand(0,1) == 1;
}

class SubscriptionService {
    public function isSubscribed($email) {
        $subscribed = randomBool();
        if($subscribed) {
            echo $email . 'already subscribed' . PHP_EOL;
        }
        return $subscribed;
    }
    public function eligibleForExtendedTrial($email) {
        $eligible = randomBool();
        if($eligible) {
            echo $email . 'is eligible for extended trial' . PHP_EOL;
        }
        return $eligible;
    }

    public function subscribeForTrial($email, $days)
    {
        echo $email . 'is subscribe for '.$days.' days!' . PHP_EOL;
    }

}

class FeatureManager {
    public function isActive($feature)
    {
        $active = randomBool();
        if($active) {
            echo $feature . 'is active!' . PHP_EOL;
        }
        return $active;

    }
}
class SocialSignIn
{
    private $subcriptionService;
    private $featureManager;

    public function __construct(SubscriptionService $subcriptionService, FeatureManager $featureManager)
    {
        $this->subcriptionService = $subcriptionService;
        $this->featureManager = $featureManager;

    }

    public function subcribeIfNewUser($email)
    {
        if (!$this->subcriptionService->isSubscribed($email)) {
            if ($this->subcriptionService->eligibleForExtendedTrial($email)) {

                $this->subcriptionService->subscribeForTrial($email, 14);
            } else if ($this->featureManager->isActive("ONE_WEEK_TRIAL")) {

                $this->subcriptionService->subscribeForTrial($email, 7);
            } else if($this->featureManager->isActive("ONE_DAY_TRIAL")) {

                $this->subcriptionService->subscribeForTrial($email, 7);
            }
        }
    }
}

$signinAdapter = new SocialSignIn(new SubscriptionService, new FeatureManager);
$signinAdapter->subcribeIfNewUser("teszt@a.hu");
