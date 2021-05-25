# Composer Plugin for Hyperf

## 安装

```
composer require hyperf/composer-plugin
```

## 使用

使用此组件可以方便的对 `files` 自动加载进行排序，比如我们在 `Laravel` 中使用 `hyperf/utils` 组件时，会因为 `Hyperf` 自动加载优于 `Laravel`，导致 `Laravel` 无法正常使用。

故我们可以降低 `hyperf/utils` 组件的加载优先级，然后重新执行 `composer dump-autoload -o` 即可解决这个问题，样例如下：

```json
"extra": {
    "hyperf": {
        "plugin": {
            "sort-autoload": {
                "hyperf/utils": -1
            }
        }
    }
},
```
