<?php

namespace App\Controller;

use App\Controller\Traits\DoctrineTrait;
use App\Controller\Traits\EventTrait;
use App\Utils\GeneralHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class BaseController
 *
 * @package App\Controller
 */
abstract class BaseController extends Controller
{
    use DoctrineTrait, EventTrait;

    /**
     * @param Request $request
     * @param string  $default
     *
     * @return RedirectResponse
     */
    protected function redirectBack(Request $request, string $default = null): RedirectResponse
    {
        return $this->redirect((null !== $default) ? $default : $request->headers->get('referer', '/'));
    }

    /**
     * {@inheritdoc}
     */
    protected function generateAbsoluteUrl($route, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL)
    {
        return $this->generateUrl($route, $parameters, $referenceType);
    }

    /**
     * @param FormInterface $form
     *
     * @return array
     */
    protected function getFormErrorMessages(FormInterface $form)
    {
        return $this->get(GeneralHelper::class)->getErrorsFromForm($form);
    }

    /**
     * @param $entity
     * @return array|bool
     */
    protected function getEntityErrorMessages($entity)
    {
        $errors = $this->get("validator")->validate($entity);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[] = [
                    "propertyPath" => $violation->getPropertyPath(),
                    "message" => $violation->getMessage()
                ];
            }

            return [
                "violations" => $messages,
            ];
        }

        return false;
    }

    /**
     * @param bool   $status
     * @param string $type
     * @param array  $parameters
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponse($status = true, $type = 'success', array $parameters = [])
    {
        $response = [
            'status' => $status,
            'type' => $type,
        ];

        return $this->json(array_merge($response, $parameters));
    }

    /**
     * @param array  $parameters
     * @param string $type
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponseSuccess(array $parameters = [], $type = 'success')
    {
        return $this->jsonResponse(true, $type, $parameters);
    }

    /**
     * @param array  $parameters
     * @param string $type
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponseError($parameters = [], $type = 'error')
    {
        return $this->jsonResponse(false, $type, $parameters);
    }


    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponseSuccessMessage($id)
    {
        return $this->jsonResponseSuccess(
            [
                'message' => $this->translator($id)
            ]
        );
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponseErrorMessage($id)
    {
        return $this->jsonResponseError(
            [
                'message'=> $this->translator($id)
            ]
        );
    }

    /**
     * @param $id
     * @param array $parameters
     * @param string $translation_domain
     * @param string $locale
     *
     * @return string
     */
    protected function translator($id, array $parameters = [], $translation_domain = 'messages', $locale = 'en')
    {
        return $this->get('translator')->trans($id, $parameters, $translation_domain, $locale);
    }

    /**
     * @param $eventName
     * @param array $arguments
     */
    protected function dispatch(string $eventName, array $arguments = [])
    {
        $event = new GenericEvent($arguments, $arguments);

        $this->get('event_dispatcher')->dispatch($eventName, $event);
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function requestReplaceContent(Request $request)
    {
        if ($request->getContent()) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace($data);
        }

        return $request;
    }
}
