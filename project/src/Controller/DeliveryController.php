<?php

namespace App\Controller;

use App\DeliveryList\DeliveryListInterface;
use App\Validator\DeliveryFieldsValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Delivery\QuickDelivery;
use App\Delivery\SlowDelivery;

class DeliveryController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/delivery', name: 'app_delivery')]
    public function index(DeliveryListInterface $deliveryList, Request $request, DeliveryFieldsValidator $validator): JsonResponse
    {
        if (!$validator->validate($request)) {
            return $this->json($validator->getErrors());
        }

        $offers = [];
        foreach ($deliveryList->getList() as $delivery) {
            /* @var SlowDelivery|QuickDelivery $delivery */
            $delivery->setSourceKladr($request->get('source_kladr'));
            $delivery->setTargetKladr($request->get('target_kladr'));
            $delivery->setWeight((float)$request->get('weight'));
            $offers[] = $delivery->getOffer();
        }
        return $this->json($offers);
    }

    /**
     * @throws \Exception
     */
    #[Route('/delivery_add', name: 'app_delivery_add')]
    public function add(DeliveryListInterface $deliveryList, Request $request, DeliveryFieldsValidator $validator): JsonResponse
    {
        if (!$validator->validate($request)) {
            return $this->json($validator->getErrors());
        }

        $uuid = $request->get('uuid');

        foreach ($deliveryList->getList() as $delivery) {
            /* @var SlowDelivery|QuickDelivery $delivery */
            if ($uuid === $delivery->getUuid()) {
                $delivery->setSourceKladr($request->get('source_kladr'));
                $delivery->setTargetKladr($request->get('target_kladr'));
                $delivery->setWeight((float)$request->get('weight'));
                return $this->json($delivery->addOrder());
            }
        }
        return $this->json(['Delivery not exist']);
    }
}
