<?php

namespace App\Controller;

use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use App\Model\Country;
use App\Model\CountryScenarios;
use App\Model\Exceptions\InvalidCodeException;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\DuplicatedCodeException;

#[Route(path: 'api/country', name: 'app_api_country')]
final class CountryController extends AbstractController
{
    public function __construct(
        private readonly CountryScenarios $countries
    ) {

    }

    // получение всех стран
    #[Route(path: '', name: 'app_api_country_root', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $newCountries = [];
        foreach ($this->countries->getAll() as $country) {
            $newCountry = new Country($country->shortName, $country->fullName,
            $country->isoAlpha2, $country->isoAlpha3, $country->isoNumeric, 
            $country->population, $country->square);
            array_push($newCountries, $newCountry);
        }
        return $this->json(data: $newCountries, status: 200);
    }

    // получение страны по коду
    #[Route(path:'/{code}', name:'app_api_country_code', methods: ['GET'])] 
    public function get(string $code): JsonResponse {
        try {
            $country = $this->countries->get($code);
            return $this->json(data: $country);
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    // добавление страны
    #[Route(path: '', name: 'app_api_country_add', methods: ['POST'])]
    public function add(#[MapRequestPayload] Country $country) : JsonResponse {
        try {
            $this->countries->store(country: $country);
            $newCountry = new Country($country->shortName, $country->fullName,
            $country->isoAlpha2, $country->isoAlpha3, $country->isoNumeric, 
            $country->population, $country->square);
            return $this->json(data: $newCountry, status: 204);
            // невалидный код
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
            // повторяющийся код
        } catch (DuplicatedCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
            // есть пустое поле
        } catch (EmptyFieldsException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
            // повторяющаяся страна
        } catch (DuplicatedCountryException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
           // отрицательное население или площадь
        } catch (InvalidFieldException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        }
    }

    // редактирование страны
    #[Route(path: '/{code}', name: 'app_api_country_edit', methods: ['PATCH'])]
    public function edit(string $code, #[MapRequestPayload] Country $country) : JsonResponse {
        try {
            $this->countries->edit(code: $code, country: $country);
            $newCountry = new Country($country->shortName, $country->fullName,
            $country->isoAlpha2, $country->isoAlpha3, $country->isoNumeric, 
            $country->population, $country->square);
            return $this->json(data: $newCountry , status: 200);
            // невалидный код
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
            // нет такого кода
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
            // отрицательное население или площадь
        } catch (InvalidFieldException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
            // нет отличных данных
        } catch (TheSameCountryException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
            // нельзя поменять ни один из уникальных кодов
        } catch (NotMatchCodesException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        }
    }

    // удаление страны
    #[Route(path: '/{code}', name: 'app_api_country_remove', methods: ['DELETE'])]
    public function remove(string $code) : JsonResponse {
        try {
            $this->countries->remove($code);
            return $this->json(data: null, status: 204);
            // невалидный код
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
            // нет страны с таким кодом
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    // вспомогательный метод формирования ошибки
    private function buildErrorResponse(Exception $ex): JsonResponse {
        return $this->json(data: [
            'errorCode' => $ex->getCode(),
            'errorMessage' => $ex->getMessage(),
        ]);
    } 
}
