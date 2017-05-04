### Setup Your Local Development Enviornment

1. Use our [Docker Setup Steps](../docker/README.md) to run this repository locally

### Branching model (release model)

1. We use the branching model found here: http://nvie.com/posts/a-successful-git-branching-model/
1. Always branch new features off the `develop` branch (`git checkout -b [featureBranchName]`)
    - featureBranchName should start with the issue number and be as short as possible (e.g. 999-example-name)
    - Important: each ticket number should only have one branch and all related changes should be kept on it
    - Tip: it is helpful to make a note of the branch name on the issue/card/ticket
1. Commit your changes to the feature branch using the ticket number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the begining of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
1. Ensure that your branch has no linting errors
1. Push your changes to this repo
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of your pull request should match the title of the task you're completing
    - Include a link to the trello card in the description
    - Include a gif of your changes. Use [licecap](http://www.cockos.com/licecap/) if you need software.
        - If your changes are difficult to include into one GIF, make two.
    - Provide a summary of the work you completed in the description of the pull request.
    - Add steps to QA so the reviewer can quickly know what changed and why
1. If there are merge conflicts fix them
1. Review the "diff" of your code
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. Request a review from the developer lead

###Branching model (continuous deployment)

1. Always branch new features off the `master` branch (`git checkout -b [featureBranchName]`)
    - featureBranchName should start with the issue number and be as short as possible (e.g. 999-example-name)
    - Important: each ticket number should only have one branch and all related changes should be kept on it
    - Tip: it is helpful to make a note of the branch name on the issue/card/ticket
1. Commit your changes to the feature branch using the ticket number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the begining of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
1. Ensure that your branch has no linting errors
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of your pull request should match the title of the task you're completing
    - Include a link to the item ticket the description
    - Include a gif of your changes. Use [licecap](http://www.cockos.com/licecap/) if you need software.
        - If your changes are difficult to include into one GIF, make two.
    - Provide a summary of the work you completed in the description of the pull request.
    - Add steps to QA so the reviewer can quickly know what changed and why
1. If there are merge conflicts, create a branch with a DEV prefix (e.g. `DEV-999-example-name)
    - merge in the `develop` branch and resolve the conflict
    - IMPORTANT: Never merge `develop` into a branch that doesn't have DEV in front of it!!!!!
1. Review the "diff" of your code
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. Request a review from the developer lead

###Code style guide

It is important that you write your code in a cost effective way that makes it easy to understand, update, and maintain. The following are some principles you should keep in mind:

- Here are [general code requirements](https://github.com/bbuie/code_snipits/wiki/Common-Code-Requirements).
- Angular code should follow [this angular style guide](https://github.com/johnpapa/angular-styleguide)