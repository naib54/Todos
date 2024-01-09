<?php
namespace App\Controller;
use App\Entity\Tasks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use vendor\symfony\form\Extension\Core\Type\DateType;
use vendor\symfony\form\Extension\Core\Type\SubmitType;
use vendor\symfony\form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Form\TodoFormType;
use Symfony\Contracts\Translation\TranslatorInterface;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(EntityManagerInterface $entityManager)
    {
        $tasks = $entityManager->getRepository(Tasks::class)->findBy(['user'=>$this->getUser()]);
        return $this->render('task/index.html.twig', [
            'tasks'=>$tasks
        ]);
    }


    #[Route('/new', name: 'app_add_task')]
     public function addForm(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response 
    {
        // Création "d'une nouvelle tâche"
        $tasks = new Tasks();

        // Création du formulaire 
        $taskForm = $this->createForm(TodoFormType::class, $tasks);

        $taskForm->handleRequest($request);
        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original '$tasks' variable also been updated
            $tasks = $taskForm->getData();
            $tasks->setUser($this->getUser());

            // tell Doctrine you want to (eventually) save the task (no queries yet)
            $entityManager->persist($tasks);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            // ... perform some action, such as saving the task to the database 
            
            $message = $translator->trans('addTaskMessage');
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_task');
            

    
        
        }
    
        return $this->render('task/form.html.twig', [
            'taskForm' => $taskForm->createView(),
        ]);
    
    }
    

       
    #[Route('/task/edit/{id}', name: 'app_edit_task')]
    public function editForm(EntityManagerInterface $entityManager, Request $request, int $id, TranslatorInterface $translator): Response
    {
        $tasks = $entityManager->getRepository(Tasks::class)->find($id);
        $taskForm = $this->createForm(TodoFormType::class, $tasks);
        $taskForm->handleRequest($request);

        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            $tasks = $taskForm->getData();

            $entityManager->persist($tasks);
            $entityManager->flush();
            
            $message = $translator->trans('modifyTask');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_task');
        }
        return $this->render(
            'task/modify.html.twig',
            [
                'taskForm' => $taskForm
            ]
        );
    }
       
       
       
        #[Route('/task/delete/{id}', name: 'app_delete_task')]
    public function delete(EntityManagerInterface $entityManager, Request $request, int $id, TranslatorInterface $translator): Response
    {
        $tasks = $entityManager->getRepository(Tasks::class)->find($id);
        
        $entityManager->remove($tasks);
        
        $entityManager->flush();
       
        $message = $translator->trans('deleteTaskMessage');
            $this->addFlash('success', $message);
        return $this->redirectToRoute('app_task');
    }
}

    

    /*#[Route('/add', name: 'add_task')]
    public function addForm(Request $request, EntityManagerInterface $entityManager): Response 
    {
        // Création "d'une nouvelle tâche"
        $tasks = new Tasks();

        // Création du formulaire 
        $taskForm = $this->createForm(TodoFormType::class, $tasks);

        // Traiter la requête du formulaire 
        // Verification de la soumission du formulaire
        $taskForm->handleRequest($request);
        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original '$tasks' variable also been updated
            $tasks = $taskForm->getData();

            // tell Doctrine you want to (eventually) save the task (no queries yet)
            $entityManager->persist($tasks);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            // ... perform some action, such as saving the task to the database 

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/add.html.twig', 
        [
            'taskForm' => $taskForm
        ]);*/



