**templates/logout.php:**

```php
<?php
// templates/logout.php
session_start();
session_destroy();
header("Location: index.php?page=login");
exit();
?>
```
