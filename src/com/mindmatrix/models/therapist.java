package src.com.mindmatrix.models;


public class therapist {
    @Override
    public String toString() {
        return "therapist [id=" + id + ", name=" + name + ", specialization=" + specialization + ", contact=" + contact
                + ", email=" + email + ", imagePath=" + imagePath + "]";
    }
    private int id;
    private String name;
    private String specialization;
    private String contact;
    private String email;
    private String imagePath;

    // Getters and Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public String getName() { return name; }
    public void setName(String name) { this.name = name; }

    public String getSpecialization() { return specialization; }
    public void setSpecialization(String specialization) { this.specialization = specialization; }

    public String getContact() { return contact; }
    public void setContact(String contact) { this.contact = contact; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }

    public String getImagePath() { return imagePath; }
    public void setImagePath(String imagePath) { this.imagePath = imagePath; }
}


