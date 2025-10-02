```mermaid
flowchart LR
    Start --> Upload Assignments
    File Validation -->|Yes| Store File
    File Validation -->|No| Upload Assigments
    Store File --> Extract File
    Extract File --> Preprocessing
    Preprocessing --> Calculate Similiarity
    Calculate Similiarity --> Store Results
    Store Results --> Display Results
    Above Threshold? -->|Yes| End
    Above Threshold? -->|No| Label as Plagiarism
    Label as Plagiarism --> END
    End
```
