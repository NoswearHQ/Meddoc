<?php
namespace App\Entity;
class data
{
    private User $user;
    private Blog $blog;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Blog
     */
    public function getBlog(): Blog
    {
        return $this->blog;
    }

    /**
     * @param Blog $blog
     */
    public function setBlog(Blog $blog): void
    {
        $this->blog = $blog;
    }

}
?>