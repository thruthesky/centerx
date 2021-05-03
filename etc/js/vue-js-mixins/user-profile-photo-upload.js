if ( typeof mixins === 'undefined' ) mixins = [];

mixins.push({
    data: function() {
        return {
            userProfilePhotoUploadPercentage: 0,
            userProfilePhotoUrl: '',
        }
    },
    methods: {
        onUserProfilePhotoChange: function(event) {
            if (event.target.files.length === 0) {
                console.log("User cancelled upload");
                return;
            }
            const file = event.target.files[0];
            const self = this;

            // 새로운 사진을 업로드한다.
            fileUpload(
                file,
                {
                    deletePreviousUpload: 'Y',
                    code: 'photoUrl'
                },
                function (res) {
                    self.userProfilePhotoUrl = res.url;
                },
                alert,
                function (p) {
                    self.userProfilePhotoUploadPercentage = p;
                }
            );
        },

    }
});



