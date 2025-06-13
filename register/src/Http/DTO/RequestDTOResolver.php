<?php
declare(strict_types=1);

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class RequestDTOResolver implements ValueResolverInterface
{
    public function __construct(private readonly ValidatorInterface $validator){
    }

    public function resolve(Request $request, ArgumentMetadata $metadata): iterable
    {
        // if apply returns false, return empty array
        if(!$this->apply($request, $metadata)){
            return [];
        }

        $class =  $metadata->getType();
        $dto = new $class($request);

        // validate dto
        $errors = $this->validator->validate($dto);
        if(\count($errors) > 0){
            throw new BadRequestHttpException((string)$errors);
        }

        return [$dto];
    }

    private function apply(Request $request, ArgumentMetadata $metadata){
        $class = $metadata->getType();
        return $class && is_subclass_of($class, RequestDTO::class);
    }
}