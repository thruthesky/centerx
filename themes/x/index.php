<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP + SPA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="/etc/css/x.css">
</head>
<body>

<div id="app">
    <header class="m-2 bg-light">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="/">Home</a> |
                    <a href="/user/register">User Register</a> |
                    <a href="/user/login">Login</a>, Logout,
                    <a href="/forum/qna/">QnA</a>,
                    <a href="/forum/discussion">Discussion</a>,
                    <a href="/forum/buyandsell">Buyandsell</a>, <span>Reminder</span>
                    <h3>PHP + Vue.js 2 + SPA 장정</h3>
                    1) Vue CLI 로 컴파일하면, PHP 로 index.html 에 SEO 를 넣어도, Vue 가 부팅하면서 id='app' 의 내용을 모두 지워버린다. 즉, SEO 는 될지 모르지만, Vue 와 연결되어 작업이 안된다.
                    하지만, PHP 만으로 Vue 를 script src=... 로 로드하면, PHP 에서 생성한 HTML 을 그대로 Vue 가 사용가능하다.
                    2) 작업을 하면서, Hot reload 를 해도 현재 페이지가 유지된다.
                    3) Natural SEO 가능하며, 모든 것이 통제 가능하다.
                    <hr>
                    <h3>SEO 및 랜딩에 따른 라우팅 전략</h3>
                    0) 사이드메뉴의 경우 그냥 PHP 로 한번 출력해버리고, Vue 에서는 건드리지 않는다.
                    1) 특히 SEO 를 위해서, 사이드 메뉴에 "전체글 보기" 등의 링크를 걸어 넣고, 그 전체 글 보기 페이지에는 Vue 를 하지 않고, PHP 만으로 카테고리별로 아주 많은 글을 주욱 보여준다.
                        즉, 검색 로봇이 게시글 수집을 할 수 있는 링크를 연결해 주는 것이다.
                    2) 내용 부분을 &lt;router-vew&gt; 태그에 집어 넣고, 새로운 페이지의 내용을 컴포넌트화해서 이 router-view 태그에 집어 넣는 것만 한다.
                    3) 홈페이지로 랜딩하나 글 목록이나 글 보기 페이지로 랜딩하나 모두 router-view 에 ajax 로 로딩해서 보여준다. 이 부분까지 SEO 로 할 필요 없다.
                </div>
            </div>
        </div>

    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-4 bg-lightgrey">
                    <?php include widget('post/bulleted-text-list')?>
                    <my-weather></my-weather>
                </div>
                <div class="col-8 bg-light">
                    <router-view :key="$route.path"></router-view>

                    <article v-if="landing">
                        <h1><?=post()->current()->title?></h1>
                        <p>
                            <?=post()->current()->content?>
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </main>
</div>

<?php js('/etc/js/common.js', 3)?>
<?php js('https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js', 2)?>
<?php js('https://unpkg.com/vue-router/dist/vue-router.min.js', 2)?>

<script type="text/x-template" id="hello-world-template">
    <p>Hello hello hello</p>
</script>
<script>

    // 모든 클릭을 캡쳐한다.
    document.querySelector("body").addEventListener('click', function(e) {
        // If it's A tag, then open the component.
        const anchor = e.target.closest('a');
        if( anchor !== null ) {
            app.aTag(e);
        }
    }, false);

    Vue.component('my-weather', {
        template: '<h1>hi</h1>',
        data: function() {
            return {};
        },
        mounted: function() {
            console.log('weather mounted');
        }
    });

    const HomeComponent = { template: '<div><h1>Home Page</h1>Welcome to SPA.</div>' };
    const UserRegisterComponent = { template: '<div><h1>Register</h1>UserRegisterComponent</div>' };
    const UserLoginComponent = { template: '<div><h1>User Login</h1><form><input></form></div>' };
    const UserProfileComponent = {
        props: ['id'],
        template: '<div>User {{ id }}. <a href="#" @click="sayHi">Say Hi ^^;</a><div>{{ data }}</div><button @click="data.count--">Decrease</button></div>',
        created: function() {
            console.log('User component created!!', this.id);
        },
        methods: {
            sayHi: function() {
                this.$set(data.obj, 'c', 'Cherry!');
            }
        }
    };
    const NotFoundComponent = {
        data: function() {
            return {
                loading: false,
                post: {},
            };
        },
        template: '<section class="d-none" :class="{\'d-block\': !$root.landing}">' +
            '<div v-if="loading">' +
            '<h1>Loading...</h1>' +
            '<div class="m-5 alert alert-danger">Please wait while loading the post ...</div>' +
            '</div>' +
            '<h1>{{ post.title }}</h1>' +
            '</section>',
        created: function () {},
        mounted: function () {
            this.loading = true;
            if ( this.$root.landing ) return;
            console.log("Get post from backend");
            console.log(location.href);
            const self = this;
            request('post.get', {path: location.href}, function (post) {
                self.loading = false;
                self.post = post;
            }, console.error);
        },
        methods: {

        }
    };

    const routes = [
        { path: '/user/register', component: UserRegisterComponent },
        { path: '/user/login', component: UserLoginComponent },
        { path: '/user/:id', component: UserProfileComponent, props: true },
        { path: '/', component: HomeComponent },
        { path: '*', component: NotFoundComponent }
    ];

    const router = new VueRouter({
        mode: 'history',
        routes: routes
    });

    const app = new Vue({
        el: '#app',
        router: router,
        data: {
            landing: true,
            obj: {},
        },
        methods: {
            aTag: function (event) {
                this.landing = false;
                event.preventDefault();
                var uri = event.target.href.split('//')[1];
                var uris = uri.split('/');
                uris.shift();
                var url = '/' + uris.join('/');
                this.obj.url = url;
                this.$router.push(url);
            },
        }
    })
</script>
</body>
</html>