**GeekHub - WebFish:**

---

**Install project**
```
- Create DB, and add settings for connected;
- $composer install; //install all librarys and reqires
- $php bin/console doctrine:fixtures:load //add castom data's for entity's
- $npm install; //install gulp
```

---

**Help**
```
- Connecting to GitHub with SSH: https://help.github.com/articles/connecting-to-github-with-ssh/
```

---

**Use commands:**
```
- $php bin/symfony_requirements - check project settings.
- $php bin/console generate:bundle - create bundle.
- $php bin/console doctrine:generate:entities BlogBundle/Entity/Info - generate get/set.
- $php bin/console doctrine:schema:update --force - update database
- $composer require friendsofsymfony/user-bundle "~2.0@dev" - install FOSUserBundle
- $php bin/console doctrine:database:create  - generate DB (deffault - geekhub_db)
- $php bin/console doctrine:generate:entities BlogBundle - generate all entities in App Bundle ((get/set)
- $php bin/console doctrine:schema:update --force - add table to DB
- $php bin/console doctrine:fixtures:load - add to table this data's (this command delete all data's, if you wont add (no delete old data) - use "--append")
- $php bin/console doctrine:schema:drop --force - drop schema
- $php bin/console fos:user:create --super-admin - create super user
- $php bin/console assets:install - install assets
```
---

**Use materials:** 
```
0) GeekHub materials - https://plus.google.com/u/0/communities/103356895682698281466
1) Http fundamentals - http://symfony.com/doc/current/introduction/http_fundamentals.html  
2) Architecture - http://symfony.com/doc/current/quick_tour/the_architecture.html
3) Configuration - http://symfony.com/doc/current/configuration.html
4) Bundles - http://symfony.com/doc/current/bundles.html 
5) Routing - http://symfony.com/doc/current/routing.html
6) Controller - https://symfony.com/doc/current/controller.html
7) External resources - http://symfony.com/doc/current/routing/external_resources.html
8) Http foundation - http://symfony.com/doc/current/components/http_foundation.html
9) Sessions - https://symfony.com/doc/current/components/http_foundation/sessions.html
10) Setting cookies - http://symfony.com/doc/current/components/http_foundation.html#setting-cookies
11) Redirect in config - http://symfony.com/doc/current/routing/redirect_in_config.html
12) Twig - http://twig.sensiolabs.org/
13) GitHub Gists - https://gist.github.com/MaximStrutinskiy
14) Formf - http://symfony.com/doc/current/reference/forms/types/form.html
15) FOSUserBundle - http://symfony.com/doc/current/bundles/FOSUserBundle/index.html
16) Security yml - http://symfony.com/doc/current/reference/configuration/security.html
17) FOSUserBundle tutorial - https://codereviewvideos.com/course/getting-started-with-fosuserbundle/video/getting-started-with-fosuserbundle;
18) Assert validation - https://symfony.com/doc/current/validation.html
19) SonataAdminBundle - https://sonata-project.org
20) Doctrine - http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html
```
---


