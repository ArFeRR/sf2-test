# Symfony2 recruitment challenge

#### Overview
A pretty simple symfony2-based blog without categories and flat(level 1 depth only) commenting system with few additional features.

#### Features
- Implement user registration/login via email and password. (you can use FOSUserBundle for it.)
- Implement blog post management(CRUD) using SonataAdminBundle.
- Implement user management(CRUD) using SonataAdminBundle.
- Implement commenting system.
- Implement external services notification(read below).

#### Blog post feature
- Blog Post includes:
  - Title
  - Username
  - DateTime of posting.
  - Content.
  - Comments(if any).
- Everyone may view posts.
- Posts management implemented via SonataAdmin.

#### Commenting system feature
- Comments include:
  - Username
  - DateTime of posting.
  - It's content(obviously).
- Everyone may view comments.
- Only logged in users can post comments.
- No page reload on comment create, use AJAX.
- Update and delete feature is an extra credit thus not required.


#### External services notification
- There are 2 abstract services that should be notified on every blogpost/comment create event: 
  - External stat system 
  - External CRM system
- You don't need to send any real requests: just put `return true;` in your `sendRequest` method or something.

#### Tips for free
- There are no requirements on front-end look&feel. Using BS3 is always a good idea. 


#### Extra credit
Develop Behat scenarios for these features:
- Read blog post
- Add comment to a blog post

#### How to proceed
- Fork this repo
- Grab some coffee.
- Start coding
- Ping @bshevchenko when you're done.
