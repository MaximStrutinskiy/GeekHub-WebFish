<?php

namespace MainBundle\Security;

use MainBundle\Entity\Comment;
use MainBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class CommentVoter
 *
 * @package MainBundle\Security
 */
class CommentVoter extends Voter {

  const VIEW = 'view_comment';
  const EDIT = 'edit_comment';
  const DELETE = 'delete_comment';

  protected function supports($attribute, $subject) {
    if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))) {
      return FALSE;
    }

    if (!$subject instanceof Comment) {
      return FALSE;
    }

    return TRUE;
  }

  protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
    $user = $token->getUser();

    if (!$user instanceof User) {
      return FALSE;
    }

// you know $subject is a Comment object, thanks to supports
    /** @var Comment $comment */
    $comment = $subject;

    switch ($attribute) {
      case self::VIEW:
        return $this->canView($comment, $user);
      case self::EDIT:
        return $this->canEdit($comment, $user);
      case self::DELETE:
        return $this->canDelete($comment, $user);
    }

    throw new \LogicException('This code should not be reached!');
  }

  private function canView(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function canEdit(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function canDelete(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function currentUserRights(Comment $comment, User $user) {
    foreach ($user->getRoles() as $role) {
      if ('ROLE_SUPER_ADMIN' === $role || 'ROLE_MODERATOR' === $role) {
        return TRUE;
      }
    }

    $getCommentUser = $comment->getUser()->get('0');
    $getCommentUserId = $getCommentUser->getId();
    $getLoginUser = $user->getId();

    if ($getCommentUserId === $getLoginUser) {
      return TRUE;
    }
    return FALSE;
  }
}
