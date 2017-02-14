<?php
namespace MainBundle\Security;

use MainBundle\Entity\Comment;
use MainBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter {
// these strings are just invented: you can use anything
  const VIEW = 'view';
  const EDIT = 'edit';
  const DELETE = 'delete';

  /**
   * @param string $attribute
   * @param mixed $subject
   *
   * @return bool
   */
  protected function supports($attribute, $subject) {
// if the attribute isn't one we support, return false
    if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))) {
      return FALSE;
    }

// only vote on Post objects inside this voter
    if (!$subject instanceof Comment) {
      return FALSE;
    }

    return TRUE;
  }

  /**
   * @param string $attribute
   * @param mixed $subject
   * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
   *
   * @return bool
   */
  protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
    $user = $token->getUser();

    if (!$user instanceof User) {
// the user must be logged in; if not, deny access
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

  /**
   * @param \MainBundle\Entity\Comment $comment
   * @param \MainBundle\Entity\User $user
   *
   * @return mixed
   */
  private function canView(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  /**
   * @param \MainBundle\Entity\Comment $comment
   * @param \MainBundle\Entity\User $user
   *
   * @return mixed
   */
  private function canEdit(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  /**
   * @param \MainBundle\Entity\Comment $comment
   * @param \MainBundle\Entity\User $user
   *
   * @return mixed
   */
  private function canDelete(Comment $comment, User $user) {
    return $this->currentUserRights($comment, $user);
  }

  /**
   * Check if current user have ROLE_ADMIN or ROLE_MODERATOR, if not - compare current user id with author of comment, if true - give CRUD permissions.
   *
   * @param Comment $comment
   * @param User $user
   *
   * @return bool
   */
  private function currentUserRights(Comment $comment, User $user) {
    foreach ($user->getRoles() as $role) {
      if ('ROLE_ADMIN' === $role || 'ROLE_MODERATOR' === $role) {
        return TRUE;
      }
    }
    if ($comment->getUser() === $user) {
      return TRUE;
    }
    return FALSE;
  }
}
