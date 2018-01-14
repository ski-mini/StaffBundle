<?php

namespace Charlotte\StaffBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CharlotteStaffBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
