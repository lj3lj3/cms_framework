<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Hello, world!</h1>
    <button class="btn btn-lg btn-link">link</button>
    <button class="btn btn-lg btn-default">link</button>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <table class="table">
                <tbody>
                <tr>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>31</td>
                    <td>32</td>
                    <td>33</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <img src="#" class="img-thumbnail" alt="Image">
    <span class="label label-default">Label</span>
    <ul class="nav nav-pills">
        <li class="active"><a href="#">active <span class="badge">3</span></a></li>
        <li><a href="#">active <span class="badge">3</span></a></li>
    </ul>

    <div class="dropdown">
        <a id="dropdownMenu1" class="sr-only dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="caret">click this</span>click this again
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li>
                <a href="#">item 1</a>
            </li>
        </ul>
    </div>

    <div>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Link</a>
            </li>
        </ul>

        <ul class="nav nav-pills">
            <li class="active">
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Link</a>
            </li>
        </ul>
    </div>

    <div class="navbar navbar-default">
        <a class="navbar-brand" href="#">Title</a>
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Link</a>
            </li>
        </ul>
    </div>

    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Title!</strong> Alert body ...
    </div>

    <div class="progress">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
        aria-valuemax="100" style="width: 20%">
            <span class="sr-only">20% Complete</span>
        </div>
    </div>

    <ul class="list-group">
        <li class="list-group-item">Item 1</li>
        <li class="list-group-item">Item 2</li>
        <li class="list-group-item">Item 3</li>
    </ul>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Panel title</h3>
        </div>
        <div class="panel-body">
            Panel body ...
        </div>
    </div>
</div>

<form action="" method="post" role="form" class="form">
	<legend>Form Title</legend>

	<div class="form-group">
		<label for=""></label>
		<input type="text" class="form-control" name="" id="" placeholder="Input...">
	</div>

	

	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="container-fluid">

</div>




</body>

<footer class="panel-footer">
    <div class="container">
            <div class="panel-body">
                Panel body ...
            </div>
    </div>
</footer>
</html>