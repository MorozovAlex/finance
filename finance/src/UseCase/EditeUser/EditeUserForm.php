<?php

namespace App\UseCase\EditeUser;

use App\Entity\DoctrineType\EmailType;
use App\Entity\DoctrineType\PhoneType;
use App\Entity\User;
use App\Service\Translator;
use App\UseCase\CreateUser\CreateUserDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EditeUserForm extends AbstractType implements DataMapperInterface
{
    public function __construct(private readonly Translator $translator)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, ['label' => 'user.lastName',])
            ->add('firstName', TextType::class, ['label' => 'user.firstName',])
            ->add('secondName', TextType::class, ['label' => 'user.secondName', 'required' => false])
            ->add('phone', TextType::class, ['label' => 'user.phone',])
            ->add('email', TextType::class, ['label' => 'user.email', 'required' => false])
            ->add('education', ChoiceType::class, [
                'label' => 'user.education.label',
                'required' => false,
                'choices'  => User::EDUCATION,
                'choice_label' => function($value) { return $this->translator->trans('user.education.choice.' . $value); },
            ])
            ->add('isPersonalData', CheckboxType::class, ['label' => 'user.isPersonalData', 'required' => false])
            // configure the data mapper for this FormType
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateUserDto::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms)
    {
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!$viewData instanceof CreateUserDto) {
            throw new UnexpectedTypeException($viewData, CreateUserDto::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // initialize form field values
        $forms['lastName']->setData($viewData->getLastName());
        $forms['firstName']->setData($viewData->getFirstName());
        $forms['phone']->setData($viewData->getPhone());
        $forms['secondName']->setData($viewData->getSecondName());
        $forms['email']->setData($viewData->getEmail());
        $forms['education']->setData($viewData->getEducation());
        $forms['isPersonalData']->setData($viewData->getIsPersonalData());
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $viewData = new CreateUserDto(
            $forms['lastName']->getData(),
            $forms['firstName']->getData(),
            $forms['phone']->getData(),
            $forms['secondName']->getData(),
            $forms['email']->getData(),
            $forms['education']->getData(),
            $forms['isPersonalData']->getData(),
        );
    }

}