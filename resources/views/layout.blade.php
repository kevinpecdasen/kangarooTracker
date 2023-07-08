<!DOCTYPE html>
<html lang="en">
    <head>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
         <!-- Bootstrap Icons CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <!-- Diagram and Gantt stylesheets -->
        <link href="https://cdn3.devexpress.com/jslib/23.1.3/css/dx-diagram.min.css" rel="stylesheet">
        <link href="https://cdn3.devexpress.com/jslib/23.1.3/css/dx-gantt.min.css" rel="stylesheet">
        <!-- Theme stylesheets (reference only one of them) -->
        <link href="https://cdn3.devexpress.com/jslib/23.1.3/css/dx.softblue.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


        <!-- Diagram and Gantt -->
        <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx-diagram.min.js"></script>
        <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx-gantt.min.js"></script>
        <!-- DevExtreme Quill (required by the HtmlEditor UI component) -->
        <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx-quill.min.js"></script>
        <!-- DevExtreme libraries (reference only one of them) -->
        <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx.all.js"></script>
        <!-- DevExpress.AspNet.Data -->
        <script src="https://cdn3.devexpress.com/jslib/23.1.3/js/dx.aspnet.mvc.js"></script>

    </head>
    <body>
        <di>
            <div class="row m-2 mt-5">
                <div class="col-12">

                </div>
                <div class="col-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item {{ $sidePanelLink === "view_all" ? 'list-group-item-secondary' : '' }}">
                            <i class="bi bi-view-list"></i>
                            <a href="/view_all">View All</a>
                        </li>
                        <li class="list-group-item {{ $sidePanelLink === "add_kangaroo" ? 'list-group-item-secondary' : '' }}">
                            <i class="bi bi-save-fill"></i>
                            <a href="/add_kangaroo">Add Kangaroo</a>
                        </li>
                    </ul>
                </div>

                <div class="col-8">
                    @section('bodyContent')
                    @show
                </div>
            </div>
        </di>
    </body>
        @section('customScripts')
        @show
</html>
