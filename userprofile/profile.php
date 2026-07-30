<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>User Profile</h1>
        <table border="0" cellpadding="8">
            <tr>
                <td>Profile Picture:</td>
                <td>
                    <input type="file" name="profilepic">
                </td>
            </tr>

            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="fullname" placeholder="Enter your full name">
                </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username" placeholder="Enter username">
                </td>
            </tr>

            <tr>
                <td>Email:</td>
                <td>
                    <input type="email" name="email" placeholder="Enter email">
                </td>
            </tr>

            <tr>
                <td>Phone Number:</td>
                <td>
                    <input type="tel" name="phone" placeholder="Enter your phone number">
                </td>
            </tr>

            <tr>
                <td>Date of Birth:</td>
                <td>
                    <input type="date" name="dob">
                </td>
            </tr>

            <tr>
                <td>Gender:</td>
                <td>
                    <input type="radio" name="gender" value="Male"> Male
                    <input type="radio" name="gender" value="Female"> Female
                </td>
            </tr>

            <tr>
                <td>Address:</td>
                <td>
                    <textarea name="address" rows="4" cols="30"></textarea>
                </td>
            </tr>

            <tr>
                <td>Country:</td>
                <td>
                    <select name="country">
                        <option value="">Select your country</option>
                        <option>Malaysia</option>
                        <option>Singapore</option>
                        <option>Thailand</option>
                        <option>Indonesia</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Password:</td>
                <td>
                    <input type="password" name="password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password:</td>
                <td>
                    <input type="password" name="confirmPassword">
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Save">
                    <input type="reset" value="Clear">
                </td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>