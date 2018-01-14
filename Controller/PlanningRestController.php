<?php

namespace Charlotte\StaffBundle\Controller;

use Tool\ToolBundle\Services\RestFunction;
use Tool\ToolBundle\Helpers\Date;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Section;

use Paradigma\Bundle\ImageBundle\Libs\ImageSize;
use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;

/**
 * @Prefix("planning")
 */
class PlanningRestController extends FOSRestController
{

    /**
     * @QueryParam(name="monthstart", strict=FALSE, description="Mois de départ")
     * @QueryParam(name="monthend", strict=FALSE, description="Mois de fin")
     * @QueryParam(name="yearstart", strict=FALSE, description="Année de départ")
     * @QueryParam(name="yearend", strict=FALSE, description="Année de fin")
     * 
     * @ApiDoc(
     *  section = "Planning",
     *  description="Retourne tous les rôles",
     *  statusCodes={
     *         200="Retourné quand ok",
     *         404="Retourné quand erreur"
     *     }
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $monthstart =   (int)$paramFetcher->get('monthstart');
        $yearstart  =   (int)$paramFetcher->get('yearstart');

        $monthend   =   (int)$paramFetcher->get('monthend');
        $yearend    =   (int)$paramFetcher->get('yearend');
        
       // var_dump($monthstart);


        $view       =   View::create();   
        $planning 	=	array();

        for ($y = $yearstart ;  $y <= $yearend ; $y++) 
        {	

            if($yearstart != $yearend)
            {
                if($y == $yearstart)
                {
                    $month1     =   $monthstart;
                    $month2     =   12;
                }
                elseif($y == $yearend)
                {
                    $month1     =   1;
                    $month2     =   $monthend;         
                }
                else
                {
                    $month1     =   1;
                    $month2     =   12;                  
                }
            }
            else
            {
                $month1     =   $monthstart;
                $month2     =   $monthend;
            }

        	for ($m = $month1 ;  $m <= $month2 ; $m++) 
        	{
                $planning[$y][$m]['idmonth']  =   str_pad($m, 2, "0", STR_PAD_LEFT);
        		$planning[$y][$m]['month']    =	  $this->getFrenchMonth(date("F", mktime(0,0,0,$m,1,$y)));

        		for($d = 1; $d <= cal_days_in_month(CAL_GREGORIAN, $m, $y); $d++)
        		{
                    $planning[$y][$m]['days'][$d]['idday']      =   str_pad($d, 2, "0", STR_PAD_LEFT);
                    $planning[$y][$m]['days'][$d]['day']        =   $this->getFrenchDay(date("l",mktime(0,0,0,$m,$d,$y)));
                    $planning[$y][$m]['days'][$d]['dayofweek']  =   date("N",mktime(0,0,0,$m,$d,$y));
        		}
        	}
        }

        $view->setStatusCode(200)->setData($planning);

        return $view;
    }

    /**
     * @QueryParam(name="nbrmonth", strict=FALSE, description="Nombre de semaine à afficher")
     * @QueryParam(name="weekstart", strict=FALSE, description="Numéro de la semaine de départ")
     * @QueryParam(name="year", strict=FALSE, description="Année")
     * 
     * @ApiDoc(
     *  section = "Planning",
     *  description="Retourne tous les rôles",
     *  statusCodes={
     *         200="Retourné quand ok",
     *         404="Retourné quand erreur"
     *     }
     * )
     */
    public function getAllWeekAction(ParamFetcher $paramFetcher)
    {
        $nbrmonth   =   (int)$paramFetcher->get('nbrmonth');
        $weekstart  =   (int)$paramFetcher->get('weekstart');
        $year       =   (int)$paramFetcher->get('year');

        $view       =   View::create();   
        $planning   =   array();

        for ($week = $weekstart ;  $week < $weekstart + $nbrmonth  ; $week++) 
        {
            $planning[$week]                    =   $this->getStartAndEndDate($week, $year);
            $planning[$week]['weekid']          =   $week;
            $planning[$week]['comment']         =   $this->getWeekcomment($week, $year);



        }
        






        $view->setStatusCode(200)->setData($planning);

        return $view;
    }





    /*
     *  Vérifie si la date passer en paramètre au format Y-m-d est un jour férié
     *  @return boolean
     */
    private function isPublicHoliday($date)
    {
        $publicholidays =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Publicholiday')
                          ->findBy(array());

        foreach ($publicholidays as $key => $value) 
        {
            if($date === $value->getDateholiday()->format('Y-m-d'))
            {
                return true;
            }
        }

        return false;
    }

    public function getFrenchMonth($month)
    {
        switch ($month) {
            case "January":
                return "Janvier";
                break;
            case "February":
                return "Février";
                break;
            case "March":
                return "Mars";
                break;
            case "April":
                return "Avril";
                break;
            case "May":
                return "Mai";
                break;
            case "June":
                return "Juin";
                break;
            case "July":
                return "Juillet";
                break;
            case "August":
                return "Août";
                break;
            case "September":
                return "Septembre";
                break;
            case "October":
                return "Octobre";
                break;
            case "November":
                return "Novembre";
                break;
            case "December":
                return "Décember";
                break;
        }
    }


    public function getFrenchDay($month)
    {
        switch ($month) {
            case "Monday":
                return "Lundi";
                break;
            case "Tuesday":
                return "Mardi";
                break;
            case "Wednesday":
                return "Mercredi";
                break;
            case "Thursday":
                return "Jeudi";
                break;
            case "Friday":
                return "Vendredi";
                break;
            case "Saturday":
                return "Samedi";
                break;
            case "Sunday":
                return "Dimanche";
                break;
           
        }
    }

    function getStartAndEndDate($week, $year)
    {
        $time = strtotime("1 January $year", time());
        $day = date('w', $time);

        $time += ((7*$week)+1-$day)*24*3600;
        $return[0]['date']              =   date('Y-m-d', $time);
        $return[0]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[0]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[1]['date']              =   date('Y-m-d', $time);
        $return[1]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[1]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[2]['date']              =   date('Y-m-d', $time);
        $return[2]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[2]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[3]['date']              =   date('Y-m-d', $time);
        $return[3]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[3]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[4]['date']              =   date('Y-m-d', $time);
        $return[4]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[4]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[5]['date']              =   date('Y-m-d', $time);
        $return[5]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[5]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        $time += 1*24*3600;
        $return[6]['date']              =   date('Y-m-d', $time);
        $return[6]['isPublicHoliday']   =   $this->isPublicHoliday(date('Y-m-d', $time));
        $return[6]['errorPlanning']     =   $this->getErrorPlanning(date('Y-m-d', $time));

        return $return;
    }

    function getWeekcomment($week, $year)
    {
        $em             =   $this->getDoctrine()->getManager();
        return $em->getRepository('CharlotteStaffBundle:Weekcomment')->findOneBy(array('year' => $year, 'weeknumber' => $week));
    }

    function getErrorPlanning($date)
    {
        $date1                  =   new \DateTime($date);
        $em                     =   $this->getDoctrine()->getManager();
        $query1                 =   $em->createQuery("SELECT cs FROM CharlotteStaffBundle:Commercialschedule cs WHERE cs.enabled = 1 AND cs.archived = 0 AND cs.dateschedule = '" .$date1->format('Y-m-d'). "' AND (cs.weektype = 1 OR cs.weektype = 3) ");
        $commercialschedule     =   $query1->getResult();

        $date2                  =   new \DateTime($date);
        $em                     =   $this->getDoctrine()->getManager();
        $query2                 =   $em->createQuery("SELECT cs FROM CharlotteStaffBundle:Commercialschedule cs WHERE cs.enabled = 1 AND cs.archived = 0 AND cs.dateschedule = '" .$date2->format('Y-m-d'). "' AND (cs.weektype = 2 OR cs.weektype = 4) ");
        $commercialschedule2    =   $query2->getResult();

        if(count($commercialschedule) < 3 || count($commercialschedule2) < 3)  
        {
            return true;
        }

        return false;
    }
}