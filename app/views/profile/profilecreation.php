<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Welcome, <?= $_SESSION['fullname']; ?>! Complete your profile Details</p>
    <form>
        <label>Add profile photo</label><br>
        <input type="file" name="profilephoto"><br><br>
               <label>Mobile Number</label>
        <input type="text" name="number" >
        <label>Religion</label><br>
        <input type="text" name="religion" required><br><br>
        <label>Caste</label><br>
        <input type="text" name="caste"><br><br>
        <label>Height</label><br>
        <input type="text" name="height"><br><br>
        <label>Education</label><br>
        <input type="text" name="education"><br><br>
        <label>Profession</label><br>
        <input type="text" name="profession"><br><br>
        <label>City</label><br>
        <input type="text" name="city" required><br><br>
        <label>About Me</label><br>
        <textarea name="about_me"></textarea><br><br>

        <a href="/user/dashboard">Skip</a>

        <button type="submit">Save Profile</button>
    </form>

</body>

</html>



 