<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapists - MindMatrix</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Therapists</h1>
        <div class="row">
            <c:forEach var="therapist" items="${therapists}">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="${therapist.imagePath}" class="card-img-top" alt="${therapist.name}">
                        <div class="card-body">
                            <h5 class="card-title">${therapist.name}</h5>
                            <p class="card-text">${therapist.specialization}</p>
                            <p class="card-text">Contact: ${therapist.contact}</p>
                            <p class="card-text">Email: ${therapist.email}</p>
                        </div>
                    </div>
                </div>
            </c:forEach>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

