<?php
/**
 * Created by PhpStorm.
 * User: charl
 * Date: 15/10/2018
 * Time: 16:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends Controller
{
    // J'ai choisi de mettre les routes dans le controller afin d'avoir une meilleur visibilité sur mes Actions
    // Néanmoins lors de gros projets, il est reccommandé de faire un fichier de routing

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $taskList = $this->getDoctrine()->getRepository(Task::class)->findAll();

        return $this->render('task/index.html.twig', array('taskList' => $taskList));
    }

    /**
     * @Route("/add", name="task_add")
     */
    public function AddAction(Request $request)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('task/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/edit/{id}", name="task_edit")
     */
    public function EditAction(Request $request, $id)
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView(), 'task' => $task]);
    }

    /**
     * @Route("/task/view/{id}", name="task_view")
     */
    public function viewAction($id)
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);

        return $this->render('task/view.html.twig', array('task' => $task));
    }

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */
    public function deleteAction($id)
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}