<div class="container">
    <div class="row" id="row_style">
        <div class="col-md-4   offset-md-4">
            <form action="" @submit.prevent="onSubmitPost()">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Title" v-model="form.title">
                </div>
                <textarea id="editor" cols="30" rows="10"
                          v-model="form.content">Submit your text post here...</textarea>
                <br>
                <br>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Tags" v-model="form.tag">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" id="submit">글쓰기</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
    mixins.push({
        data: {
            form: {
                title: '',
                content: '',
                tag: '',
                categoryId: 'join',
            }
        },
        methods: {

            onSubmitPost: function () {
                request('post.create', this.form, '', alert)
            }
        }
    })

</script>