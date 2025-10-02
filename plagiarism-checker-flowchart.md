```mermaid
flowchart TD
    A[Start] --> B{Is it a valid paper?}
    B -->|Yes| C[Check for plagiarism]
    B -->|No| D[Reject Paper]
    C --> E{Plagiarism Detected?}
    E -->|Yes| F[Flag Paper]
    E -->|No| G[Accept Paper]
    F --> H[Notify Author]
    H --> [END]
    G --> [END]
```