####  redis的简要封装
虽然是对 laravel　中　redis facade 的封装
但是用户应该优先使用 ext-redis 扩展　
根据之前在丁香园的压力测试 ext-redis 的扩展性能要远远优于 predis/predis

当使用　predis 的时候　报出了　resolved host error 的错误的时候　
使用 ext-redis 后减少了该错误
