<?php

namespace App\Repositories;

use App\Interfaces\DashboardRepositoryInterface;
use App\Models\Development;
use App\Models\Event;
use App\Models\FamilyMember;
use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;

class DashboardRepository implements DashboardRepositoryInterface
{

    public function getDashboardData()
    {
        return [
            'residents'             => HeadOfFamily::count() + FamilyMember::count(),
            'head_of_families'      => HeadOfFamily::count(),
            'social_assistances'    => SocialAssistance::count(),
            'events'                => Event::count(),
            'developments'          => Development::count()
        ];
    }
}
