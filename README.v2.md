# Matrix


## Boot


### PHP 스크립트 호출 순서

- `index.php`
  시작 스크립트
    
  - `boot.php`
    부팅 스크립트. 어느 위치의 스크립트이든 이 스크립트를 include 하면, Matrix 를 부팅하여 사용 할 수 있다.
  
  - `themes/theme-name/index.php`
    `boot.php` 가 실행된 후, `view()->file('index')` 를 통해서 해당 테마의 index.php 를 실행한다.
    Vuejs 2 의 index.html 을 실행한다면, `include 'index.html';` 와 같이 하면 된다.

## Theme 파일

```php
d(view()->file('index'));
d(view()->page());
```
