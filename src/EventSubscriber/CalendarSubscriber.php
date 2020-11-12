<?php

namespace App\EventSubscriber;

use App\Entity\Ateliers;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use http\Env\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $eventRepository;
    private $atelierRepository;
    private $router;

    public function __construct(
        EventsRepository $eventRepository,
        AteliersRepository $ateliersRepository,
        UrlGeneratorInterface $router
    ) {
        $this->eventRepository = $eventRepository;
        $this->atelierRepository = $ateliersRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
//        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $events = $this->eventRepository
            ->createQueryBuilder('event')
            ->where('event.dateDebut BETWEEN :start and :end OR event.dateFin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        $ateliers = $this->atelierRepository
            ->createQueryBuilder('atelier')
            ->where('atelier.dateDebut BETWEEN :start and :end OR atelier.dateFin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($events as $event) {
            // this create the events with your data (here booking data) to fill calendar
            $eventEvent = new Event(
                $event->getNom(),
                $event->getDateDebut(),
                $event->getDateFin() // If the end date is null or not defined, a all day event is created.
            );


            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $eventEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);


            $eventEvent->addOption(
                'url',
                $this->router->generate('events_show', [
                    'id' => $event->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($eventEvent);
        }

        foreach ($ateliers as $atelier) {
            // this create the events with your data (here booking data) to fill calendar
            $atelierEvent = new Event(
                $atelier->getNom(),
                $atelier->getDateDebut(),
                $atelier->getDateFin() // If the end date is null or not defined, a all day event is created.
            );


            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $atelierEvent->setOptions([
                'backgroundColor' => 'green',
                'borderColor' => 'green',
            ]);


            $atelierEvent->addOption(
                'url',
                $this->router->generate('ateliers_show', [
                    'id' => $atelier->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($atelierEvent);
        }
    }
}
