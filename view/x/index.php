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
                </div>
            </div>
        </div>

    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-4 bg-lightgrey">
                    <?php include widget('post/bulleted-text-list')?>
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

<?php js('/etc/js/common.js', 2)?>
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


    const UserLoginComponent = {
        template: '<div>' +
            '<h1>User Login</h1>' +
            '<form @submit.prevent="onSubmit">' +
            '<div class="form-group"> Email ' +
            '<input type="text" name="email">' +
            '</div>' +
            '<div class="form-group"> Password ' +
            '<input type="password" name="password">' +
            '</div>' +
            '<button type="submit" class="btn btn-primary">Submit</button>' +
            '</form>' +
            '</div>',
        methods: {
            onSubmit: function(event) {
                const data = serializeJSON(event.target);
                console.log(data);
                request('user.login', data, function(res) {
                    console.log(res);
                }, console.error);
            }
        }
    };

    const UserRegisterComponent = {
        template: '<div>' +
            '<h1>User Register</h1>' +
            '<form @submit.prevent="onSubmit">' +
            '<div class="form-group"> Email ' +
            '  <input type="text" name="email">' +
            '</div>' +
            '<div class="form-group"> Password ' +
            '  <input type="password" name="password">' +
            '</div>' +
            '<div class="form-group"> Name ' +
            '  <input type="text" name="name">' +
            '</div>' +
            '<button type="submit" class="btn btn-primary">Submit</button>' +
            '</form>' +
            '</div>',
        methods: {
            onSubmit: function(event) {
                const data = serializeJSON(event.target);

                console.log(data);
                request('user.register', data, function(res) {
                    console.log(res);
                }, console.error);
            }
        }
    };

    const HomeComponent = { template: '<div><h1>Home Page</h1>Welcome to SPA.</div>' };
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