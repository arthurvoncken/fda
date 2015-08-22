<?php

namespace FDA\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDAUserBundle extends Bundle
{

	public function getParent()
    {
      return 'FOSUserBundle';
    }
}
