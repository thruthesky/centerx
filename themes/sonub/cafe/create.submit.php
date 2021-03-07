<?php
if (isRealNameAuthUser() == false) return displayWarning('본인 인증을 한 사용자만 카페 개설이 가능합니다.');
