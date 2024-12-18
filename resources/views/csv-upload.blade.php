<!DOCTYPE html>
<html>
<head>
    <title>Email Processing</title>
</head>
<body>
    <form action="/process-emails" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="excel_file" accept=".xlsx,.xls,.csv">
        <button type="submit">Process Emails</button>
    </form>
    <form action="/get-email-records" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file" accept=".xlsx,.xls,.csv">
    <button type="submit">Get Records Emails</button>
</form>

    <script>
        // Optional: Add AJAX handling for form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            
            fetch('/process-emails', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Processing Results:', data);
                // You can update the page with the results
                document.body.innerHTML += `
                    <div>
                        <h3>Email Processing Results</h3>
                        <p>Total Emails: ${data.total_emails}</p>
                        <p>Existing Emails: ${data.existing_count}</p>
                        <p>Missing Emails: ${data.missing_count}</p>
                        <h4>Missing Emails List:</h4>
                        <pre>${JSON.stringify(data.missing_emails, null, 2)}</pre>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        document.querySelector('form[action="/get-email-records"]').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch('/get-email-records', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Records Found:', data);
        // You can update the page with the results
        document.body.innerHTML += `
            <div>
                <h3>User Records</h3>
                <p>Total Emails in File: ${data.total_emails_in_file}</p>
                <p>Records Found: ${data.records_count}</p>
                <pre>${JSON.stringify(data.records_found, null, 2)}</pre>
            </div>
        `;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
    </script>
</body>
</html>