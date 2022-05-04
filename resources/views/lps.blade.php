<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LPs</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css"
          integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>

    <style>
        label {
            min-width: 300px;
        }

        .form-group {
            width: 25%;
        }

        .select2-container {
            width: 285px !important;
        }

        .add-composer-btn {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = \Illuminate\Support\Facades\Session::get('success'))
        <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <h1>LPs</h1>
    <p>
        <a class="btn btn-primary" data-toggle="collapse" href="#collapseNew" role="button"
           aria-expanded="false"
           aria-controls="collapseNew">
            + New
        </a>
    </p>

    <div class="collapse" id="collapseNew">
        <div class="card card-body">
            <form method="post">
                @csrf
                <div class="container">
                    <div class="form-group">
                        <label for="name">LP name</label>
                        <input type="text" class="form-control" required id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="published_on">Published on</label>
                        <input type="date" required class="form-control" id="published_on" name="published_on">
                    </div>
                    <div>
                        <input type="checkbox" id="label-switch"> Label not found, add new
                    </div>
                    <div class="form-group toggle-label-container">
                        <label for="label-select">
                            Label<br>
                            <select class="label-select js-states form-control toggle-label" id="label-select"
                                    name="label_id" style="width: 100%">
                            </select>
                        </label>
                    </div>

                    <div class="form-group toggle-label-container" style="display: none">
                        <label for="add-label">Add Label</label>
                        <input type="text" class="form-control toggle-label" id="add-label" name="add_label">
                    </div>

                    <div class="form-group composer-container">
                        <label for="composer-select" class="w-50">
                            Composer(s)<br>
                            <select multiple class="composer-select js-states form-control width100"
                                    name="composer_id[]"
                                    id="composer-select">
                            </select>
                        </label>
                    </div>
                    <div class="form-group">
                        <span class="btn-sm btn-primary add-composer-btn" id="add-composer-btn">
                            Add composer if not in
                        </span>
                    </div>

                    <div class="form-group">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Label</th>
            <th scope="col">Composer(s)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lps as $lp)
            <tr>
                <th scope="row">{{ $lp->id }}</th>
                <td>{{ $lp->name }}</td>
                <td>{{ $lp->label }}</td>
                <td>{{ $lp->composers }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function () {

        $("#label-select").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/api/label',
                dataType: 'json',
                type: "GET",
                quietMillis: 50,

                results: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $("#composer-select").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/api/composer',
                dataType: 'json',
                type: "GET",
                quietMillis: 50,

                results: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $('#label-switch').on('click', function () {
            $('.toggle-label-container').toggle();
            $('.toggle-label').prop('value', '');
        });

        $('#add-composer-btn').on('click', function () {
            $('.composer-container').append('<input type="text" class="form-control" name="add_composer[]" style="margin-bottom: 5px" placeholder="Composer name">');
        });
    });
</script>
</body>
</html>
