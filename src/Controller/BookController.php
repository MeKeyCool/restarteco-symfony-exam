<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends AbstractController
{
    /**
     * return all books' name in json format
     */
    #[Route('/books/list', name: 'list-of-my-books', methods: ['POST'], format: 'json')]
    public function book(EntityManagerInterface $entityManager)
    {
        $book_list = $entityManager->getRepository("App\Entity\Book")->findAll();

        // @TODO current response filtering is forced by `Book::jsonSerialize()` 
        // method but it isn't a valid long terme solution 
        return new JsonResponse(
            [
                'result' => [
                    'data' => $book_list
                ],
            ]
        );
    }

    /**
     * parcour all books and add sufix on name
     */
    #[Route('/books/add-sufix', name: 'add-sufix-on-my-books', methods: ['GET'], format: 'json')]
    public function addSufix(string $suffix)
    {
        $books = $this->container->get('doctrine.orm.default_entity_manager')->getRepository("App\Entity\Book")->findBy([]);

        foreach ($books as $book) {
            $book->name .= ' - Sufix';
            $this->container->get('doctrine.orm.default_entity_manager')->persist($book);
            $this->container->get('doctrine.orm.default_entity_manager')->flush();
        }


        $template = $this->container->get('twig')->load('book/index.html.twig');

        return $template->render([
            'return' => json_encode([
                'data' => json_encode('ok'),
                'books' => json_encode($books)
            ]),
        ]);
    }
}
