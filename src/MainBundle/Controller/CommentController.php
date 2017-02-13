<?php
namespace MainBundle\Controller;

use MainBundle\Entity\Comment;
use MainBundle\Entity\Post;
use MainBundle\Forms\FormCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller {

  public function editAction(Request $request, Post $post, $id, $commentId) {
    $em = $this->getDoctrine()->getManager();
    $postRepository = $em->getRepository("MainBundle:Post");
    $post = $postRepository->find($id);
    $postCountComment = $postRepository->findCountPostsWithCommentResult($id);

    $commentRepository = $em->getRepository("MainBundle:Comment");
    $commentPost = $commentRepository->findAllComments($id);

    if (!$commentId) {
      $comment = new Comment();
    }
    else {
      $comment = $this->getDoctrine()
        ->getRepository('MainBundle:Comment')
        ->find($commentId);
    }
    $comment->setPost($post);
    $form = $this->createForm(FormCommentType::class, $comment);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $comment = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($comment);
      $em->flush();
      $this->addFlash('success', 'Comment was successfully updated!');
      return $this->redirect($this->generateUrl('blog-post', [
        'id' => $post->getId(),
        'shortTitle' => $post->getShortTitle(),
      ]));
    }

    return $this->render('MainBundle:Page:_internal_blog.html.twig', [
      'post' => $post,
      'show_comment' => $commentPost,
      'form_comment' => $form->createView(),
      'count_comment' => $postCountComment->getResult(),
    ]);
  }
}
