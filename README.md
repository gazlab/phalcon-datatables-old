# Phalcon DataTables

A library for use DataTables in PhalconPHP project.

## Getting Started

## Model Adapter

### View

```
<table id="model" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#model').DataTable({
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

    public function modelAction()
    {
        if ($this->request->isAjax()){
            DataTable::model('Post')->send();
        }
    }
}
```

### Installing

### Composer (recomended)

```
composer require gazlab/phalcon-datatables
```

On app/config/loader.php project

```
$loader = new \Phalcon\Loader();

require_once BASE_PATH . '/vendor/autoload.php';
```

## Authors

* **Sony Kusyana** - *sonykusyana* - [Gazlab](https://github.com/gazlab)