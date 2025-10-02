# Plagiarism Checker Workflow

This flowchart shows the complete workflow for the plagiarism checker assignments system.

```mermaid
graph TD
    A[User Login/Registration] --> B[Dashboard]
    B --> C[Upload Assignment]
    C --> D[File Validation]
    D --> E{Valid File?}
    E -->|No| F[Show Error Message]
    F --> C
    E -->|Yes| G[Store File in Database]
    G --> H[Initialize Plagiarism Check]
    H --> I[Text Extraction Service]
    I --> J[Similarity Analysis]
    J --> K[Compare with Database]
    K --> L[Compare with External Sources]
    L --> M[Calculate Similarity Score]
    M --> N[Generate Report]
    N --> O[Store Results]
    O --> P[Display Results to User]
    P --> Q{Acceptable Score?}
    Q -->|No| R[Flag for Review]
    Q -->|Yes| S[Mark as Approved]
    R --> T[Notify Administrator]
    S --> U[Assignment Submitted]
    T --> V[Manual Review Process]
    V --> W{Administrator Decision}
    W -->|Reject| X[Notify Student]
    W -->|Approve| S
    X --> Y[Student Revision Required]
    Y --> C
    
    style A fill:#e1f5fe
    style G fill:#f3e5f5
    style J fill:#fff3e0
    style N fill:#e8f5e8
    style R fill:#ffebee
    style S fill:#e8f5e8
```

## Workflow Description

### Key Components:
1. **User Management** - Login/registration system
2. **File Upload & Validation** - Handling assignment submissions
3. **Text Processing** - Extraction and analysis services
4. **Plagiarism Detection** - Similarity checking against database and external sources
5. **Reporting** - Generate and display results
6. **Review Process** - Manual review for flagged submissions
7. **Decision Flow** - Approval or rejection workflow

### Technical Architecture (Laravel-based):
- **Controllers** (app/Http) - Handle user requests and responses
- **Models** (app/Models) - Data management for assignments, users, results
- **Services** (app/Services) - Core plagiarism checking logic
- **Views** (Blade templates) - User interface for uploading and viewing results
- **Database** - Store assignments, similarity scores, and user data

The workflow ensures thorough checking while providing both automated and manual review processes for comprehensive plagiarism detection.

Generated on: 2025-10-02 07:19:52 UTC