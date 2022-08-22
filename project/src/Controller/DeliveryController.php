<?php

namespace App\Controller;

use App\DeliveryList\DeliveryListInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validation;
use App\Delivery\QuickDelivery;
use App\Delivery\SlowDelivery;

class DeliveryController extends AbstractController
{
    #[Route('/delivery', name: 'app_delivery')]
    public function index(DeliveryListInterface $deliveryList, Request $request): JsonResponse
    {
        $validator = Validation::createValidator();

        $jsonErrors = [];

        $fromKladr = $request->get('from_kladr');
        $targetKladr = $request->get('target_kladr');
        $weight = (float)$request->get('weight');

        $errors = $validator->validate($fromKladr, [new NotBlank()]);
        if (0 !== count($errors)) {
            foreach ($errors as $name => $error) {
                $jsonErrors['from_kladr'][] = $error->getMessage();
            }
        }

        $errors = $validator->validate($targetKladr, [new NotBlank()]);
        if (0 !== count($errors)) {
            foreach ($errors as $name => $error) {
                $jsonErrors['target_kladr'][] = $error->getMessage();
            }
        }

        $errors = $validator->validate($weight, [
            new NotBlank(),
            new Positive(),
        ]);
        if (0 !== count($errors)) {
            foreach ($errors as $name => $error) {
                $jsonErrors['weight'][] = $error->getMessage();
            }
        }

        if ([] !== $jsonErrors) {
            return $this->json($jsonErrors);
        }

        foreach ($deliveryList->getList() as $delivery) {
            /* @var SlowDelivery|QuickDelivery $delivery */
            $delivery->setSourceKladr($fromKladr);
            $delivery->setTargetKladr($targetKladr);
            $delivery->setWeight($weight);
        }
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DeliveryController.php',
        ]);
    }
}
