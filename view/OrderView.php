<div class="clearfix"></div>
<h1 class="page-title">Order #<?php echo $id?></h1>
<div class="clearfix"></div>

<style>
    .message-container {
        display: flex;
    }

    .info-side {
        width: 30%;
        padding: 10px;
    }

    .chat-side {
        width: 70%;
        padding: 10px;
    }

    .card {
        padding: 10px;
        border-radius: 11px;
        position: relative;
    }

    .square {
        width: 100%;
        height: 250px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #F3F3F3;
    }

    .data {
        text-align: center;
    }

    .data-title {
        font-size: 20pt;
    }

    .data-semi-text {
        color: grey;
    }

    .right {
        text-align: right;
    }

    #chat-container {
        height: 400px;
        overflow-y: scroll;
    }

    .received {
        align-self: start;
        padding: 10px;
        position: relative;
        white-space: pre-wrap;
        text-align: left;
        direction: ltr;
        display: block;
    }

    .received div {
        align-self: start;
        padding: 10px;
        width: auto;
        background-color: #1D80D6;
        margin-bottom: 3px;
        color: white;
        border-radius: 0px 10px 10px 10px;
        display: inline-block;

    }

    .sent {
        text-align: right;
        align-self: end;
        padding: 10px;
    }

    .sent div {
        text-align: right;
        align-self: end;
        padding: 10px;
        width: auto;
        background-color: #ECECEC;
        margin-bottom: 3px;
        color: black;
        border-radius: 10px 0px 10px 10px;
        display: inline-block;
    }
</style>

<div class="message-container">
    <div class="info-side">
        <div class="card square">
            <div class="data">
                <div class="data-title">
                    <?php echo $title?>
                </div>
                <div class="data-semi-text">
                    <?php echo $user?>
                </div>
            </div>
        </div>
        <br>
        <table>
            <tr>
                <td>Product</td>
                <td class="right"><?php echo $product?></td>
            </tr>
            <tr>
                <td>Budget</td>
                <td class="right"><?php echo $budget?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td class="right"><?php echo $select?></td>
            </tr>
        </table>

    </div>
    <div class="chat-side">
        <div id="chat-container">

        </div>
        <div class="form-cnt ">
            <input placeholder="your message here" id="send-input"/>
        </div>

    </div>
</div>

<script>
    var order_id = <?php echo $id?>;
    var chat_container = $("#chat-container");
    var last_message = 0;

    function goToBottom() {
        chat_container.scrollTop(chat_container[0].scrollHeight);
    }

    function sendMessage(message) {
        chat_container.append(`<div class="sent"><div>${message}</div></div>`);
        goToBottom();
    }

    function receiveMessage(message){
        chat_container.append(`<div class="received"><div>${message}</div></div>`);
        goToBottom();
    }

    $('#send-input').keypress(function (e) {
        let keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            $('#send-input').prop('disabled', true);
            $.post( "Order/SendMessage?id="+order_id,"message="+$("#send-input").val(), function( data ) {

            }).always(function() {
                $('#send-input').prop('disabled', false);
                fetchMessages();
                $('#send-input').val("");
            });
        }
    });

    $('#status-select').on('change', function() {
        let val = this.value;
        $.post( "Order/ChangeStatus?id="+order_id,"status="+val, function( data ) {

        })
    });

    window.setInterval(function(){
        fetchMessages();
    }, 1000);

    function fetchMessages(){
        $.post("Order/listMessages?id="+order_id,"last_message="+last_message, function( data ) {
            for(let i = 0; i < data.length; i++){
                if(data[i]["sender"] === "received"){
                    receiveMessage(data[i]["message"]);
                }else if(data[i]["sender"] === "sent"){
                    sendMessage(data[i]["message"])
                }
                if(last_message < data[i]["date"]){
                    last_message = data[i]["date"];
                }
            }
        });
    }
</script>