<?php
$limit = !empty(in('limit')) ? in('limit') : 100;
$conds=[];
if(modeSubmit()) {
    $status = !empty(in('status')) ? in('status')  : 'success';
    $conds[] = "status='" . $status . "'";
    if(in('idx')) $conds[] = "idx='" . in("idx") . "'";
    if(in('userIdx')) $conds[] = "userIdx='" . in("userIdx") . "'";
    if(in('platform')) $conds[] = "platform='" . in("platform") . "'";
    if(in('productID')) $conds[] = "productID='" . in("productID") . "'";
    if (in('beginDate')) $conds[] = "createdAt>='" . strtotime(in('beginDate')) . "'";
    if (in('endDate')) $conds[] = "createdAt<'" . strtotime(in('endDate')) + 24 * 60 * 60 . "'";
} else {
    $conds[] = "status='success'";
}
$where = implode(" AND ", $conds);
//d($where);

$rows = inAppPurchase()->search(where: $where, limit: intVal($limit), object: true);

$total_price = [];
$user_total_spend = [];
foreach ($rows as $row) {
    $price_prefix = mb_substr($row->price, 0,1);
    if (!isset($total_price[$price_prefix])) $total_price[$price_prefix] = 0;
    if (!isset($user_total_spend[$row->userIdx])) $user_total_spend[$row->userIdx] = [];
    if (!isset($user_total_spend[$row->userIdx][$price_prefix])) $user_total_spend[$row->userIdx][$price_prefix] = 0;

    $price = mb_substr($row->price, 1);
    $price = str_replace(",", "", $price);
    $total_price[$price_prefix] += floatval($price);
    $user_total_spend[$row->userIdx][$price_prefix] += floatval($price);
}
//d($user_total_spend);
?>

<h1>In app purchase</h1>
<section id="in-app-purchase">


    <form ref="inAppPurchase" method="post" action="/">

        <?=hiddens(in: ['p', 'w'], mode: 'submit')?>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="idx">idx</label>
                <input type="text" class="form-control" placeholder="idx" name="idx" id="idx"  value="<?=in('idx')?>">
            </div>
            <div class="form-group col-md-3">
                <label for="userIdx">UserIdx</label>
                <input type="text" class="form-control" placeholder="userIdx" name="userIdx" id="userIdx"  value="<?=in('userIdx')?>">
            </div>
            <div class="form-group col-md-3">
                <label for="status">Status</label>
                <select class="custom-select" id="status" name="status">
                    <option value="success" <?=in('status') == 'success' ? 'selected' : ''?>>Success</option>
                    <option value="pending" <?=in('status') == 'pending' ? 'selected' : ''?>>Pending</option>
                    <option value="failure" <?=in('status') == 'failure' ? 'selected' : ''?>>Failure</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="platform">Platform</label><?=in('platform')?>
                <select class="custom-select" id="platform" name="platform">
                    <option value="" <?=empty(in('platform')) ? 'selected' : ''?>>Select platform</option>
                    <option value="android"  <?=in('platform') == 'android' ? 'selected' : ''?>>Android</option>
                    <option value="ios" <?=in('platform') == 'ios' ? 'selected' : ''?>>IOS</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="productID">Product ID</label>
                <input type="text" class="form-control" placeholder="productID" name="productID" id="productID"  value="<?=in('productID')?>">
            </div>
            <div class="form-group col-md-3">
                <label for="limit">Limit</label>
                <input type="text" class="form-control" placeholder="limit" name="limit" id="limit"  value="<?=$limit?>">
            </div>
            <div class="form-group col-md-3">
                <label for="beginDate">Date begin</label>
                <input class="form-control" name="beginDate" placeholder="Date begin(YYYYMMDD)" id="beginDate" v-model="beginDate">
            </div>
            <div class="form-group col-md-3">
                <label for="endDate">Date End</label>
                <input class="form-control" name="endDate" placeholder="Date end(YYYYMMDD)" id="endDate" v-model="endDate">
            </div>
        </div>


        <div class="d-flex justify-content-start mt-2 mb-3">
            <button type="button" class="btn btn-primary mr-3" @click="selectDateRange(7)">
                7 days
            </button>
            <button type="button" class="btn btn-primary mr-3" @click="selectDateRange(15)">
                15 days
            </button>
            <button type="button" class="btn btn-primary mr-3" @click="selectDateRange(30)">
                30 days
            </button>

            <button type="button" class="btn btn-primary mr-3" @click="lastMonth()">
                last month
            </button>
        </div>


        <div class="d-flex justify-content-between mt-2 mb-3">
            <div>
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </div>
        </div>
    </form>

    <div class="total-price mb-5">
        <h4 @click="showTotalSummary = !showTotalSummary">Total Summary</h4>
        <div v-if="showTotalSummary">
            <div class='font-weight-bold'>Total Price Summary</div>
            <?php
            foreach ($total_price as $currency => $value) {
                echo "<div>$currency: $value</div>";
            }
            echo "<div class='font-weight-bold'>Individual Price Summary</div>";
            foreach ($user_total_spend as $userIdx => $total_price) {
                $user = user($userIdx);
                echo "<div class='font-weight-bold'>{$user->name}({$user->idx})</div>";
                foreach ($total_price as $currency => $value) {
                    echo "<div>$currency: $value</div>";
                }
            }
            ?>
        </div>
    </div>



    <div class="custom-control custom-checkbox custom-control-inline" v-for="(option, key) in options" :key="key">
        <input type="checkbox" class="custom-control-input" :id="key + '-option'" v-model="options[key]">
        <label class="custom-control-label text-capitalize" :for="key + '-option'">{{key}}</label>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User(Idx)</th>
            <th scope="col" v-if="options.status">Status</th>
            <th scope="col" v-if="options.platform">Platform</th>
            <th scope="col" v-if="options.productID">ProductID</th>
            <th scope="col" v-if="options.purchaseID">PurchaseID</th>
            <th scope="col" v-if="options.price">Price</th>
            <th scope="col" v-if="options.title">Title</th>
            <th scope="col" v-if="options.description">Description</th>
            <th scope="col" v-if="options.applicationUsername">Application Username</th>
            <th scope="col" v-if="options.transactionDate">TransactionDate</th>
            <th scope="col" v-if="options.productIdentifier">ProductIdentifier</th>
            <th scope="col" v-if="options.quantity">Quantity</th>
            <th scope="col" v-if="options.transactionIdentifier">TransactionIdentifier</th>
            <th scope="col" v-if="options.transactionTimeStamp">TransactionTimeStamp</th>
            <th scope="col" v-if="options.localVerificationData">localVerificationData</th>
            <th scope="col" v-if="options.serverVerificationData">serverVerificationData</th>
            <th scope="col" v-if="options.localVerificationData_packageName">localVerificationData_packageName</th>
            <th scope="col" v-if="options.createdAt">createdAt</th>
            <th scope="col" v-if="options.updatedAt">updatedAt</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row) {
            $user = user( $row->userIdx );
            ?>
            <tr>
                <th scope="row"><?=$row->idx?></th>
                <td><?=$user->name?>(<?=$user->idx?>)</td>
                <td v-if="options.status"><?=$row->status?></td>
                <td v-if="options.platform"><?=$row->platform?></td>
                <td v-if="options.productID"><?=$row->productID?></td>
                <td v-if="options.purchaseID"><?=$row->purchaseID?></td>
                <td v-if="options.price"><?=$row->price?></td>
                <td v-if="options.title"><?=$row->title?></td>
                <td v-if="options.description"><?=$row->description?></td>
                <td v-if="options.applicationUsername"><?=$row->applicationUsername?></td>
                <td v-if="options.transactionDate"><?=$row->transactionDate ? date('Y/m/d H:i', $row->transactionDate/ 1000): ''?></td>
                <td v-if="options.productIdentifier"><?=$row->productIdentifier?></td>
                <td v-if="options.quantity"><?=$row->quantity?></td>
                <td v-if="options.transactionIdentifier"><?=$row->transactionIdentifier?></td>
                <td v-if="options.transactionTimeStamp"><?=$row->transactionTimeStamp?></td>
                <td v-if="options.localVerificationData"><?=$row->localVerificationData?></td>
                <td v-if="options.serverVerificationData"><?=$row->serverVerificationData?></td>
                <td v-if="options.localVerificationData_packageName"><?=$row->localVerificationData_packageName?></td>
                <td v-if="options.createdAt"><?=date('Y/m/d H:i', $row->createdAt)?></td>
                <td v-if="options.updatedAt"><?=date('Y/m/d H:i', $row->updatedAt)?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>

<script>
    mixins.push({
        data: {
            showTotalSummary: true,
            beginDate: "<?=in('beginDate')?>",
            endDate: "<?=in('endDate')?>",
            options: {
                status: true,
                platform: true,
                productID: true,
                purchaseID: false,
                price: true,
                title: true,
                description: false,
                applicationUsername: false,
                transactionDate: false,
                productIdentifier: false,
                quantity: false,
                transactionIdentifier: false,
                transactionTimeStamp: false,
                localVerificationData: false,
                serverVerificationData: false,
                localVerificationData_packageName: false,
                createdAt: true,
                updatedAt: false,
            }
        },
        methods: {
            selectDateRange: function(days) {
                let x = new Date();
                let newDate = new Date(x.getTime() - 1000*60*60*24*days);
                this.beginDate = this.yyyymmddFromDate(newDate);
                this.endDate = this.yyyymmddFromDate(x);
                this.$nextTick( function () {
                    this.$refs['inAppPurchase'].submit();
                });
            },
            lastMonth: function() {
                let x = new Date();
                this.beginDate = this.yyyymmddFromDate(new Date(x.getFullYear(), x.getMonth() - 1, 1));
                this.endDate = this.yyyymmddFromDate(new Date(x.getFullYear(), x.getMonth(), 0));
                this.$nextTick(function () {
                    this.$refs['inAppPurchase'].submit();
                });
            },
            yyyymmddFromDate: function(date) {
                let y = date.getFullYear().toString();
                let m = (date.getMonth() + 1).toString();
                let d = date.getDate().toString();
                (d.length === 1) && (d = '0' + d);
                (m.length === 1) && (m = '0' + m);
                return y + m + d;
            }
        }
    });
</script>


