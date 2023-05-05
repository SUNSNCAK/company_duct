<div class="login-form-container">
    <span id="close-login-form" class="bi bi-x"></span>

    <form action="home.php" method="post" class="login-form">
        <h3>เข้าสู่ระบบ</h3>
        <input type="email" id="email" name="email" placeholder="อีเมล" class="box">
        <div class="d-flex position-relative">
            <input type="password" id="password" placeholder="รหัสผ่าน" name="password" class="box">
            <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                <h4 class="bi bi-eye-slash mb-0" id="togglePassword" style="cursor: pointer;"></h4>
            </div>
        </div>
        <input type="submit" value="เข้าสู่ระบบ" name="signin" class="btnn">
        <p> หากยังไม่มีบัญชี <a href="#" id="toregister">สมัครใช้งาน</a></p>
    </form>
</div>
<div class="register-form-container">
    <form action="home.php" method="post" class="register-form">
        <h3>สมัครสมาชิก</h3>
        <input type="text" id="name" name="name" placeholder="ชื่อ-นามสกุล" class="box">
        <input type="email" name="email" placeholder="อีเมล" class="box">
        <input type="password" name="password" placeholder="รหัสผ่าน" class="box">
        <input type="password" name="re-password" placeholder="ยืนยันรหัสผ่าน" class="box">
        <input type="tel" id="phone" name="number" placeholder="โทรศัพท์" class="box" pattern="[0-9]{10}" required>
        <input type="submit" value="สมัครสมาชิก" name="register" class="btnn">
        <p class="message">มีบัญชีอยู่แล้ว? <a href="#" id="tologin">เข้าสู่ระบบ</a></p>
    </form>
</div>