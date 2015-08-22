<?php
namespace FDA\SiteBundle\Twig;

class StripAccentExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('stripaccent', array($this, 'stripFilter'))
        );
    }
 
    public function stripFilter($value)
    {
		$trans = array(" " => "-", "é" => "e", "è" => "e", "ê" => "e", "ï" => "i");
        return strtr($value, $trans);
    }
 
    public function getName()
    {
        return 'stripaccent_extension';
    }
 
}
?>