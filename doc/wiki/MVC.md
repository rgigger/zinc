## MVC

The term MVC stands for Model View Controller. It's history is long and varied and has been discussed widely on the
interweb. The gist of it is that originally it was a specific type of separation of concerns for desktop application
code. It was original invented by SmallTalk developers and then morphed into something else by Sun and then again by
Next. Eventually it became standard practice for desktop frameworks to be built using some form of it. At some point
some web developers took something kind of similar and started calling it MVC because it had something called a model,
something called a view, and something called a controller, even though they didn't necessarily mean the same things or
interact in the same ways as the desktop MVC conventions. There was a lot of debate for a while as to what should
and shouldn't be called MVC. Eventually everyone just kept calling all of it MVC.

The stance of Zinc on this issue is that we don't care. Zinc developed zones (front controllers), templating systems
(views), and the DbObject class (base class for standard models) before we knew that anyone was calling anything on the
web MVC. This is the reason that we don't have base classes called Model, View, and Controller. We think that there is a
reason why so many disparate web frameworks have converged on the same basic architecture. It's simple and it works. So
Zinc could be considered and MVC or a Web MVC framework depending on your definitions for those terms. We just continue
to try to do what works, you can call it what you want. We have continued using our old terminology but may reference
models, views, and controllers in our docs from time to time to make things more clear for people already comfortable
with that terminology.