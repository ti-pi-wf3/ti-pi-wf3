<?php

namespace App\Controller;

use App\Entity\ToDoList;
use App\Form\ToDoListType;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ToDoListController extends AbstractController
{
    


    /**
     * @Route("/todolist/add", name="to_do_list")
     * @Route("/todolist/{id}/edit", name="to_do_list_edit")
     * 
     */

    public function add(ToDoList $toDoList = null, Request $request, EntityManagerInterface $manager): Response
    {
        
        if(!$toDoList)
        {
        $toDoList = new ToDoList();
        }

        $formToDoList = $this->createForm(ToDoListType::class, $toDoList);
        $formToDoList->handleRequest($request);

        

        if($formToDoList->isSubmitted() && $formToDoList->isValid())
        {   
            if(!$toDoList->getId()){
            $toDoList->setDate(new \DateTime());
            }

            //recuperation cle etrangere
            $user = $this->getUser();

            $toDoList->setUser($user);

            

            $manager->persist($toDoList);
            $manager->flush();

            // $this->addFlash('success', "Le mémo a bien été modifié");

            return $this->redirectToRoute('show_to_do_list', [
                'id'=> $toDoList->getId()
            ]);
        }


        return $this->render('to_do_list/add.html.twig', [
            'formToDoList' => $formToDoList->createView(),
            'editMode'=> $toDoList->getId()
        ]);
    }


    /**
     * @Route("/showtodolist", name="show_to_do_list")
     * @Route("/showtodolist/{id}/remove", name="remove_to_do_list")
     */
    public function viewAll(ToDoListRepository $repoToDoLists, EntityManagerInterface $manager, ToDoList $memoRemove = null )
    {   
        // dump($memoRemove);

        $user = $this->getUser();

        $toDoLists = $repoToDoLists->findby(array('user'=>$user), array("date" => "DESC"));

        if($memoRemove)
        {
            $manager->remove($memoRemove);
            $manager->flush();
            return $this->redirectToRoute('show_to_do_list');
        }


        return $this->render('to_do_list/show.html.twig', [
            'todolistsBDD'=>$toDoLists
        ]);
    }

    
}
