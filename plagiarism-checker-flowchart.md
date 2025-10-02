 A[User Login/Registration] --> B[Dashboard]
    B --> C[Upload Assignment]
    C --> D[File Validation]
    D --> E{Valid File?}
    E -->|No| F[Show Error Message]
    F --> C
    E -->|Yes| G[Store File in Database]
    G --> H[Initialize Plagiarism Check]
    H --> I[Preprocessing]
    I --> J[Calculate Similarity]
    J --> O[Store Results]
    O --> P[Display Results]
    P --> Q{Acceptable Score Threshold?}
    Q -->|No| Y[Mark as Plagiarism]
    Q -->|Yes| Y[Mark as Approved]
    Y --> END
