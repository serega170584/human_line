<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validation;

class DeliveryFieldsValidator
{
    private array $errors;

    public function validate(Request $request): bool
    {
        $validator = Validation::createValidator();

        $fieldErrors = [];

        $sourceKladr = $request->get('source_kladr');
        $targetKladr = $request->get('target_kladr');
        $weight = (float)$request->get('weight');

        $errors = $validator->validate($sourceKladr, [new NotBlank()]);
        if (0 !== count($errors)) {
            foreach ($errors as $error) {
                $fieldErrors['source_kladr'][] = $error->getMessage();
            }
        }

        $errors = $validator->validate($targetKladr, [new NotBlank()]);
        if (0 !== count($errors)) {
            foreach ($errors as $error) {
                $fieldErrors['target_kladr'][] = $error->getMessage();
            }
        }

        $errors = $validator->validate($weight, [
            new NotBlank(),
            new Positive(),
        ]);
        if (0 !== count($errors)) {
            foreach ($errors as $error) {
                $fieldErrors['weight'][] = $error->getMessage();
            }
        }

        $this->errors = $fieldErrors;

        return [] === $this->errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
