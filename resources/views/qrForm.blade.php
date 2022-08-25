<style type="text/css">

    .form {
        display: flex;
        flex-direction: column;
    }

    .marginBotton {
        margin-bottom: 15px;
    }
</style>

<form method="post" action="{{route('qr.createQr')}}">

    <div class="form">
        <div class="marginBotton">
            <label>
                سریال نامبر
            </label>
            <input type="number" name="serial_number" id="serial_number">
        </div>
        <div class="marginBotton">
            <label>
                نام
                <input type="نام" name="fullname" id="fullname">
            </label>
        </div>
        <div class="marginBotton">
            <label>
                موبایل
                <input type="number" name="mobile" id="mobile"/>
            </label>
        </div>
        <div class="marginBotton">
            <label>1</label>
            <input type="radio" name="type" value="1">
            <label>2</label>
            <input type="radio" name="type" value="2">
            <label>3</label>
            <input type="radio" name="type" value="3">
        </div>
    </div>

    <input type="submit">

</form>
