<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use GuzzleHttp\Client;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use GuzzleHttp\Exception\ClientException;

class ContainsPostcodeValidator extends ConstraintValidator
{
    /**
     * @var Client $http
     */
    private $http;

    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsPostcode) {
            throw new UnexpectedTypeException($constraint, ContainsPostcode::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (preg_match('/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i', $value, $matches)) {
            try {
                $this->http->get('/postcodes/'.$value);
            }
            catch(ClientException $e) {
                $this->returnInvalid($value, $constraint->message);
            }
        }
        else {
            $this->returnInvalid($value, $constraint->message);
        }

    }

    private function returnInvalid($value, $message)
    {
        $this->context->buildViolation($message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}