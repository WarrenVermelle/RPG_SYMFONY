<?php
namespace App\EventSubscriber;

use App\Entity\Champion;
use App\Entity\Inventory;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;


class RequestSubscriber implements EventSubscriberInterface
{
    private $security;
    private $em;

    public function __construct( Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (str_starts_with($event->getRequest()->getPathInfo() ,'/game' )){

            $user = $this->security->getUser();

            $champion = $this->em->getRepository(Champion::class)->findOneBy([
                'player' =>$user,
                'actif' => true
            ]);

            $inventory = $this->em->getRepository(Inventory::class)->findBy([
                'champ' => $champion
            ]);

            $equipedList = $this->em->getRepository(Inventory::class)->findBy([
                'champ' => $champion,
                'equiped' => true
            ]);
           
            $request = $event->getRequest()->getSession();
            $request->set('championActif', $champion);
            $request->set('Item', $equipedList);
            $request->set('inventory', $inventory);
        }
    }
}
