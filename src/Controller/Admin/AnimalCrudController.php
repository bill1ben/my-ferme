<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\MediaType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class AnimalCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel('animal.fields.name'),
            TextField::new('type')->setLabel('animal.fields.type'),
            IntegerField::new('age')->setLabel('animal.fields.age'),
            TextField::new('breed')->setLabel('animal.fields.breed'),
            MoneyField::new('priceTTC')->setLabel('animal.fields.price_ttc')->setCurrency('EUR'),
            MoneyField::new('priceHT')->setLabel('animal.fields.price_ht')->setCurrency('EUR'), 
            TextareaField::new('description')->setLabel('animal.fields.discription')->hideOnIndex(),
            CollectionField::new('medias')
                ->setLabel('animal.fields.media')
                ->setEntryType(MediaType::class)
                ->renderExpanded()
                ->addFormTheme("admin/media_field.html.twig"),
            DateTimeField::new('updatedAt')->hideOnForm(),
            ];

    }
}
