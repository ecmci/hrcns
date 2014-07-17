<!DOCTYPE html>
<html>

<head>
<link href="css/normalize.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery.steps.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/jquery.steps.min.js"></script>

</head>


<body>
<section id="async">
                <h2 class="page-header">Procedures</h2>
                <div id="wizard-7">
                    <h5>First Stage</h5>
                    <section data-mode="async" data-url="/Examples/AsyncContent">
                    </section>

                    <h5>Second Step</h5>
                    <section>
                        <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque. 
                            In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum 
                         </p>
                    </section>

                    <h5>Third Step</h5>
                    <section>
                        <p>Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo condimentum dapibus. Fusce eros justo, 
                            pellentesque non euismod ac, rutrum sed quam. Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat. 
                            </p>
                    </section>

                    <h5>Forth Step</h5>
                    <section>
                        <p>Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor. 
                            </p>
                    </section>

                </div>
            </section>

			
			  <script>
        $(document).ready(function ()
        {
            $("#wizard-7").steps({
                headerTag: "h5",
                bodyTag: "section",
                transitionEffect: "slide"
            });
        });
    </script>

</body>
</html>