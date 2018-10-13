[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/s0ny)

# Phalcon DataTables

A library for use DataTables in PhalconPHP project.

## Getting Started

### View

```
<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "index/model",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "title" },
            { "data": "body" }
        ]
    });
</script>
```

### Controller
```
use DataTables\DataTable;

class IndexController extends ControllerBase
{

    /* Model Adapter */
    public function modelAction()
    {
        if ($this->request->isAjax()){
            DataTable::model('Post')->send();
        }
    }
}
```

### Installing

#### Composer (recommended)

```
composer require gazlab/phalcon-datatables
```

On your project, app/config/loader.php

```
$loader = new \Phalcon\Loader();

require_once BASE_PATH . '/vendor/autoload.php';
```

## Authors

* **Sony Kusyana** - *sonykusyana* - [Gazlab](https://github.com/gazlab)