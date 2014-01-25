//
//  ViewController.h
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <AVFoundation/AVFoundation.h>

@interface ViewController : UIViewController{
    AVAudioPlayer *titleSe;
    __weak IBOutlet UISwitch *seSwitch;
    __weak IBOutlet UILabel *maxPointLabel;
}
@property BOOL seOnOff;
@property int maxPoint;
- (IBAction)gameStartBtn:(id)sender;
- (IBAction)switchChanged:(id)sender;

@end
