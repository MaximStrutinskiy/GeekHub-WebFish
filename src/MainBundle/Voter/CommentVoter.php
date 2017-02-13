<?php
namespace MainBundle\Voter;

use MainBundle\Entity\Comment;
use MainBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter {
  const DELETE = 'ROLE_SONATA_ADMIN_COMMENT_DELETE';
  const EDIT = 'ROLE_SONATA_ADMIN_COMMENT_EDIT';
  const CREATE = 'ROLE_SONATA_ADMIN_COMMENT_CREATE';

  protected function supports($attribute, $subject) {
    if (!in_array($attribute, array(self::EDIT, self::DELETE, self::CREATE))) {
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
    /** @var Comment $comment */
    $comment = $subject;
    switch ($attribute) {
      case self::EDIT:
        return $this->canEdit($comment, $user);
      case self::DELETE:
        return $this->canDelete($comment, $user);
      case self::CREATE:
        return $this->canCreate($comment, $user);
    }
    throw new \LogicException('This code should not be reached!');
  }

  private function canEdit(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function canDelete(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function canCreate(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  private function currentUserRights(Comment $comment, User $user) {
    foreach ($user->getRoles() as $role) {
      if ('ROLE_ADMIN' === $role || 'ROLE_MODERATOR' === $role) {
        return TRUE;
      }
    }
    if ($comment->getUser()->getId() === $user->getId()) {
      return TRUE;
    }
    return FALSE;
  }
}
