<?php

namespace App\Helpers;

class GetGreetings
{
    /**
     * Get the appropriate greeting message based on the time of day.
     *
     * @return string
     */
    public static function getGreeting(): string
    {
        $hour = date('H');

        if ($hour >= 5 && $hour < 12) {
            return 'Good Morning';
        } elseif ($hour >= 12 && $hour < 17) {
            return 'Good Afternoon';
        } else {
            return 'Good Evening';
        }
    }
}


// Usage example
// echo GetGreetings::getGreeting(); // Outputs: Good Morning, Good Afternoon, or Good Evening based on the current time.   